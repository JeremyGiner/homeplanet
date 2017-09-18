<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use homeplanet\Entity\Character;
use Symfony\Component\Form\Form;
use homeplanet\Entity\Conversation;
use homeplanet\modifier\conversation\Imitate;
use homeplanet\Entity\Expression;
use homeplanet\validator\ValidatorAnd;
use homeplanet\validator\PointCost;
use homeplanet\modifier\conversation\ChangeLead;
use homeplanet\modifier\conversation\AddPoint;
use homeplanet\modifier\conversation\GivePoint;
use homeplanet\validator\conversation\OpponentPointRequire;
use homeplanet\modifier\conversation\AddDebate;
use homeplanet\Entity\homeplanet\Entity;

/**
 * @Route("/character")
 */
class CharacterController extends BaseController {
	
//_____________________________________________________________________________
//	Action
	
	/**
	 * 
	 * @Route("", name="character")
	 */
	public function mainAction() {
		
	}
	
	
	/**
	 * Display character's info
	 * @Route("/{id}", name="character_view", requirements={"id": "\d+"})
	 */
	public function viewAction( $id, Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$oCharacter = $this->getGame()->getCharacterRepo()->find( $id );
		
		if( $oCharacter == null ) throw $this->createNotFoundException('No character found');
		
		// Form debate
		
		
		
		// Render
		return $this->render('homeplanet/page/character_view.html.twig', [
				'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
				'character' => $oCharacter,
		]);
	}
	
	/**
	 * Display character's info
	 * @Route("/acquaintance", name="character_acquaintance")
	 */
	public function acquaintanceAction( Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$aAquaintance = $this->getGame()->getCharacterRepo()->getAcquaintance( $this->getGame()->getPlayer() );
		
		// Meet form
		/* @var $oFormMeet Form */
		$oFormMeet = $this->createFormBuilder()
			->add('submit',SubmitType::class,['label' => 'Meet new charater'])
			->getForm()
		;
		
		$oFormMeet->handleRequest( $oRequest );
		if( $oFormMeet->isSubmitted() && $oFormMeet->isValid() ) {
			
			$em = $this->getGame()->getEntityManager();
			
			$oConversation = new Conversation( 
				$this->getGame()->getPlayer()->getCharacter(),
				$this->getGame()->getPlayer()->getCharacter()->getExpressionAr(),
				
				$this->getGame()->getCharacterRepo()->getRandom( null ),
				$this->getGame()->getPlayer()->getCharacter()->getExpressionAr()
			);
			$em->persist( $oConversation );
			$em->flush();
			
			$this->redirect( $this->generateUrl('conversation_view',['id' => $oConversation->getId(),]));
		}
		
		return $this->render('homeplanet/page/acquaintance.html.twig', [
				'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
				'characterList' => $aAquaintance,
				'form_meet' => $oFormMeet->createView(),
		]);
	}
	
	/**
	 * 
	 * @Route("/travel", name="travel")
	 */
	public function travelAction( Request $oRequest ) {
		//TODO
		$this->_handleRequest( $oRequest );
		
		$oForm = $this->createFormBuilder([],['csrf_protection' => false])
			->setMethod('GET')
			->add( SubmitType::class, [ 'label' => 'Meet a random character' ] )
			->getForm()
		;
		$oForm->handleRequest( $oRequest );
		
		$aCharacter = null;
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			$aCharacter = $this->_oGame->getCharacterRepo()->getRandomList( $this->_oLocation );
		}
		
		return $this->render('homeplanet/page/.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'characterList' => $aCharacter,
		]);
	}
	
	/**
	 * 
	 * @Route("/expression", name="character_expression")
	 */
	public function expressionAction( Request $oRequest ) {
		
		/*
# Update knowledge expression
INSERT IGNORE INTO knowledge ( knowledge.`id`,knowledge.`label`, knowledge.`type`, knowledge.reference) 
SELECT id+10000,' ','expression', id FROM expression
		 */
		
		$this->_handleRequest( $oRequest );
		
		//______________________________
		//DEV
		//GENERATE expression
		/*
		$em = $this->getGame()->getEntityManager();
		
		function array_cartesian() {
			$_ = func_get_args();
			if(count($_) == 0)
				return array(array());
			$a = array_shift($_);
			$c = call_user_func_array(__FUNCTION__, $_);
			$r = array();
			foreach($a as $v)
				foreach($c as $p)
					$r[] = array_merge(array($v), $p);
				return $r;
		}
		function get_type() {
			static $a = [];
			if( empty( $a ) ) {
				$a = array( 0,1,2,3 );
			}
			$k = array_rand($a);
			$v = $a[ $k ];
			unset( $a[ $k ] );
			return $v;
		}
		function get_score(
				$aTail,
				$iDebateGain,
				$iPointGain,
				$iPointGiven,
				$bCounter
		) {
			$i = 0;
			$i += $iDebateGain * 10;
			$i += $iPointGain * 20;
			$i -= $iPointGiven * 30;
			$i += ( $bCounter ) ? 50 : 0;  
			return $i;
		}
		function get_complexity(
				$aTail,
				$iDebateGain,
				$iPointGain,
				$iPointGiven,
				$bCounter
		) {
			$i = 0;
			$i += $iDebateGain != 0 ? 1 : 0;
			$i += $iPointGain != 0 ? 1 : 0;
			$i += $iPointGiven != 0 ? 1 : 0;
			$i += ( $bCounter ) ? 1 : 0;  
			return $i;
		}
		$aCombination = array_cartesian(
			[// tail
					[0,1],
					[0,2],
					[0,3],
					[1,2],
					[1,3],
					[2,3],
					[0,1,2],
					[0,1,3],
					[1,2,3],
			],
			range(0,5),		// debate
			range(-5,5),	// gain
			range(-5,5),	// given
			[true,false]	// counter
		);
		foreach( $aCombination as $a ) {
			// Filter complexity
			if( get_complexity($a[0], $a[1], $a[2], $a[3], $a[4]) > 3 ) 
				continue;
			
			// Filter by score
			$iScore = get_score($a[0], $a[1], $a[2], $a[3], $a[4]);
			if( $iScore != 50 )
				continue;
			
			$oExpresion = Expression::generateExpression(
					get_type(), 
					$a[0], $a[1], $a[2], $a[3], $a[4]
			);
			
			$em->persist( $oExpresion );
		} 
		$em->flush();
		//_____________________________
		*/
		/**
		 * Persuade : 0
		 * Coerce : 1
		 * Passion : 2
		 * Charm : 3
		 */
		$oExpression = $this->getGame()->getEntityManager()
			->find(Expression::class, 1300);
		
		$oExpression->setRequirement( new ValidatorAnd([
			//new PointCost( 1, 2 ),
			new OpponentPointRequire(3, 5),
		]) );
		//$oExpression->setRequirement( null );
		
		$oExpression->setEffect( [ 
			//new Counter(),
			//new AddPoint(1, -3),
			//new GivePoint(0, 1),
			//new AddPoint(0, 1),
			
			//new AddPoint(3, -1),
			//new ChangeLead(ChangeLead::GIVE),
			//new Imitate(),
			
			new AddDebate(10),
				
		] );
		
		
		
		$this->getGame()->getEntityManager()->flush();
		
		//_____________________________
		
		$oExpressionRepo = $this->getGame()->getExpressionRepo();
		
		$aExpression = $oExpressionRepo->findAll();
		
		$aOwnership = $oExpressionRepo->getIdByPlayerOwnership( $this->getGame()->getPlayer()->getId() );
		
		$aDeck = $oExpressionRepo->getIdByPlayerDeck( $this->getGame()->getPlayer()->getId() );
		
		return $this->render('homeplanet/page/expression_list.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'expressionList' => $aExpression,
			'expressionOwnershipAr' => array_flip( $aOwnership ),
			'deck' => $aDeck,
		]);
	}
	
//_____________________________________________________________________________
// Sub-routine


	
}

