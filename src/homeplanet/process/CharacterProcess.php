<?php
namespace homeplanet\process;

use Doctrine\ORM\EntityManager;
use homeplanet\Entity\GameState;
use homeplanet\Entity\Character;
use homeplanet\character_action\CharacterAction;
use homeplanet\character_action\WeddingProposal;
use homeplanet\character_action\WorkProposal;
use homeplanet\Entity\CharacterHistory;
use homeplanet\factory\CharacterBuilderByParent;
use homeplanet\validator\character\CharacterMarryValidator;

/**
 * php console/bin homeplanet:character-process
 *
 */
class CharacterProcess {
	
	protected $_oEM;
	protected $_iTurn;
	
	//TODO: move to repository
	const AGE_ABLE_MIN = 3;
	const AGE_ABLE_MAX = 20;
	
	public function __construct( EntityManager $oEntityManager ) {
		$this->_oEM = $oEntityManager;
	}
	
	public function process() {
		$this->_processAllCharacterDecision();
		$this->_processEvent();
	}
	
	public function __invoke() {
		// TODO : chekc argument count
		$this->process();
	}
	
	protected function _processEvent() {
		
		// List character 
			// in age
			// with mate 
			// no recent child birth or wedding
			// with genre female
			// exclude player character
		$oQuery = $this->_oEM->createQuery(
'SELECT character
FROM homeplanet\Entity\Character character
JOIN character._aHistory history
LEFT JOIN character._oPlayer player
WHERE history._sType IN ( :history_type )
AND character._iCreated BETWEEN :too_old AND :too_young
AND character._sGenre = :genre
AND player._iId IS NULL
GROUP BY character
HAVING MAX(history._iCreated) <= :recent'
			)
			->setParameters( [
				'too_young' => $this->_iTurn - self::AGE_ABLE_MIN,
				'too_old' => $this->_iTurn - self::AGE_ABLE_MAX,
				'recent' => $this->_iTurn-3,
				'genre' => 'female',
				'history_type' => [ 
					CharacterHistory::WEDDING_PROPOSAL, 
					CharacterHistory::CHILD_BIRTH, 
				],
			] )
			->useQueryCache(true)
			->useResultCache(false)
		;
		
		// @var $aCharacter Character[]
		$aCharacter = $oQuery->getResult();
		
		// Randomize and cut
		//TODO: use properity
		shuffle($aCharacter);
		$aCharacter = array_slice($aCharacter, floor(count($aCharacter)/2) );
		
		// Create child birth event
		foreach( $aCharacter as $oCharacter ) {
			$oChild = (new CharacterBuilderByParent(
				$this->_oEM,
				$oCharacter,
				$oCharacter->getMate()
			))->create();
			
			$this->_oEM->persist($oChild);
			$this->_oEM->flush($oChild);
			
			$this->_oEM->persist(
				CharacterHistory::STcreateTypeChildBirth(
					$oCharacter, 
					$oCharacter->getMate(), 
					$oChild, 
					$this->_iTurn
				)
			);
			
			echo $oChild->getLabel().' is born'."\n";
		}
	}
	
	protected function _processAllCharacterDecision() {
		
		// Get turn
		$oGameState = $this->_oEM->getRepository(GameState::class)->find(1);
		$this->_iTurn = $oGameState->getTurn();
		
		// Get able character list non-ruler
		$oQuery = $this->_oEM->createQuery(
'SELECT character
FROM homeplanet\Entity\Character character
WHERE character._aLifegoal IS NOT NULL
AND character._iCreated BETWEEN :too_old AND :too_young'
			)
			->setParameters( array(
				'too_young' => $this->_iTurn-self::AGE_ABLE_MIN,
				'too_old' => $this->_iTurn-self::AGE_ABLE_MAX,
			))
			->useQueryCache(true)
			->useResultCache(false)
		;
		
		// @var $aCharacter Character[]
		$aCharacter = $oQuery->getResult();
		
		var_dump(count( $aCharacter ));
		
		// Randomize order
		shuffle($aCharacter);
		
		// Deleguate
		foreach( $aCharacter as $oCharacter ) {
			$this->_processCharacterDecision($oCharacter);
		}
	}
	
	protected function _processCharacterDecision( Character $oCharacter ) {
		
		// List possible actions
		$aAction = $this->_getActionList( $oCharacter );
		
		// Case : no possible action
		if( empty( $aAction ) )
			return null;
		
		// Sort by motivation
		//TODO
		shuffle( $aAction );
		// @var $oAction CharacterAction
		$oAction = array_pop( $aAction );
		
		// Perform action
		$aHistory = $oAction();
			
		// Persist modifer
		foreach( $aHistory as $oHistory ) {
			$this->_oEM->persist( $oHistory );
			$this->_oEM->flush();
		}
	}
	
	/**
	 * 
	 * @return CharacterAction[]
	 */
	protected function _getActionList( Character $oCharacter ) {
		$a = [];
		
		// List wedding proposal action
		$a = array_merge( $a, $this->_getWeddingProposalActionList($oCharacter) );
		
		// List work proposal action
		$a = array_merge( $a, $this->_getWorkProposalActionList($oCharacter) );

		//TODO
		
		return $a;
	}
	
	protected function _getWeddingProposalActionList( Character $oCharacter ) {
		
		// Filter already wed
		if( $oCharacter->getMate() != null )
			return [];
		
		// List valid target character
			// not current character
			// does nto have a mate
			// around same age
			// same location
			// get first
		$oQueryBuilder = $this->_oEM->createQueryBuilder()
			->select('character')
			->from('homeplanet\Entity\Character', 'character')
			->andWhere('character._x = :x')->andWhere('character._y = :y')
			->setParameters( [
				'x' => $oCharacter->getLocationX(),
				'y' => $oCharacter->getLocationY(),
			])
		;
		CharacterMarryValidator::STmodify($oQueryBuilder, 'character', $oCharacter );
		
		$oQueryBuilder->getQuery()
			->useQueryCache(true)
			->useResultCache(false)
			->setMaxResults(1)
		;
			
		// @var $oTarget Character
		$oTarget = $oQuery->getOneOrNullResult();
		
		if( $oTarget != null )
			return [ new WeddingProposal( $oCharacter, $oTarget, $this->_iTurn ) ];
		return [];
	}
	
	protected function _getWorkProposalActionList( Character $oCharacter ) {
		
		// Filter worker
		if( $oCharacter->getContract() != null )
			return [];
		
		/*
		// List work place
			// same location
			// have space
		$oQuery = $this->_oEM->createQuery(
'SELECT pawn
FROM homeplanet\Entity\Pawn pawn
JOIN pawn._aWorker worker
JOIN pawn._aPosition position
WHERE position._x = :x AND position._y = :y
GROUP BY pawn
HAVING pawn._iGrade < count(worker)'
			)
			->setParameters( [
				'x' => $oCharacter->getLocationX(),
				'y' => $oCharacter->getLocationY(),
			])
			->useQueryCache(true)
			->useResultCache(false)
		;
			
		// @var $oTarget Pawn
		$oTarget = $oQuery->getOneOrNullResult();
		
		if( $oTarget != null )
			return [ new WorkProposal( $oCharacter, $oTarget, $this->_iTurn ) ];
		*/
		return [];
	}
}

