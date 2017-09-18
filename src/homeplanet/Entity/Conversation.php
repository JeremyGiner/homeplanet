<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;
use homeplanet\Entity\part\ConversationContext;
use homeplanet\Entity\part\ConversationState;
use homeplanet\Entity\part\homeplanet\Entity\part;

/**
 * @ORM\Table(name="conversation")
 * @ORM\Entity
 */
class Conversation {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\OneToOne(
	 *     targetEntity="\homeplanet\Entity\Character", 
	 *     cascade={"persist"}
	 * )
	 * @ORM\JoinColumn(name="character0_id", referencedColumnName="id")
	 * @var Character
	 */
	protected $_oCharacter0;
	
	/**
	 * @ORM\OneToOne(
	 *     targetEntity="\homeplanet\Entity\Character", 
	 *     cascade={"persist"}
	 * )
	 * @ORM\JoinColumn(name="character1_id", referencedColumnName="id")
	 * @var Character
	 */
	protected $_oCharacter1;
	
	/**
	 * State of the conversation
	 * there is supposed to be only one object at index 0 (the array is there to fix a Doctrine bug )
	 * see stackoverflow.com/questions/30193351/how-to-update-doctrine-object-type-field
	 * 
	 * @ORM\Column(type="object", name="state")
	 * @var ConversationState[] 
	 */
	protected $_aState;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct(
		Character $oCharacter0,
		array $aDeck0,
		Character $oCharacter1,
		array $aDeck1
	) {
		$this->setState(new ConversationState(
			array_map(function( Expression $o ){ return $o->getId(); }, $aDeck0 ),
			$this->draw($aDeck0),
			array_map(function( Expression $o ){ return $o->getId(); }, $aDeck1 ),
			$this->draw($aDeck1)
		));
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getCharacter0() {
		return $this->_oCharacter0;
	}
	
	public function getCharacter1() {
		return $this->_oCharacter1;
	}
	
	public function getContext0() {
		return new ConversationContext($this, $this->getCharacter0() );
	}
	public function getContext1() {
		return new ConversationContext($this, $this->getCharacter1() );
	}
	
	/**
	 * 
	 * @param Character $oCharacter
	 * @return int[]
	 */
	public function getHand( Character $oCharacter ) {
		$i = $this->getCharacterIndex($oCharacter);
		return $this->getState()->getHand($i);
	}
	
	/**
	 * State of the conversation
	 * @return ConversationState
	 */
	public function getState() {
		return reset( $this->_aState );
	}
	
	public function getCharacterIndex( Character $oCharacter ) {
		if( $oCharacter == $this->getCharacter0() ) return 0;
		if( $oCharacter == $this->getCharacter1() ) return 1;
		throw new Exception('Character is not in this conversation');
	}
	public function getOpponentIndex( Character $oCharacter ) {
		if( $oCharacter == $this->getCharacter0() ) return 1;
		if( $oCharacter == $this->getCharacter1() ) return 0;
		throw new Exception('Character is not in this conversation');
	}
	
	public function draw( array $aDeck ) {
		shuffle( $aDeck );
		return [
			array_pop( $aDeck ),
			array_pop( $aDeck ),
			array_pop( $aDeck ),
		];
	}
	
//_____________________________________________________________________________
// Modifier
	
	public function setState( ConversationState $oState ) {
		$k = array_keys($this->_aState);
		$this->_aState = [ (reset( $k )+1) => $oState ];
		return $this;
	}
	
//_____________________________________________________________________________
// Process
	
	public function processExpression( Expression $oExp0, Expression $oExp1 ) {
		
		// Reset tail
		$this->getState()->setTail([]);
		
		if( $this->getState()->getCharacterLeading() == 0 ) {
			$oExpLeading = $oExp0;
			$oExpFollowing = $oExp1;
		} else {
			$oExpLeading = $oExp1;
			$oExpFollowing = $oExp0;
		}
		
		// Create context
		$oContext0 = new ConversationContext(
			$this, 
			$this->getCharacter0(), 
			$oExp0,
			$oExp1 
		);
		$oContext1 = new ConversationContext(
			$this, 
			$this->getCharacter1(), 
			$oExp1,
			$oExp0 
		);
		
		// Get value
		$oAddDebate = $oExp0->getAddDebate();
		$iExp0Value = ($oAddDebate !== null) ? 
			$oAddDebate->getValue() + $oAddDebate->getBonus($oContext0) :
			-1;
		
		$oAddDebate = $oExp1->getAddDebate();
		$iExp1Value = ($oAddDebate !== null) ? 
			$oAddDebate->getValue() + $oAddDebate->getBonus($oContext1) :
			-1;
		
		// Process modifier if their expression value is greater or equal
		if( $iExp0Value >= $iExp1Value )
		foreach( $oExp0->getEffectAr() as $oModifier )
			$oModifier->modify( $oContext0 );
		
		if( $iExp1Value >= $iExp0Value )
		foreach( $oExpFollowing->getEffectAr() as $oModifier )
			$oModifier->modify( $oContext1 );
		
		// Update debate point
		//$this->getState()->updateDebate();
		
		// Update log
		$this->getState()->addLog($oExp0, $oExp1);
		
		// Draw 3
		$this->getState()->setHand0( 
			$this->draw( $this->getState()->getDeck0() ) 
		);
		$this->getState()->setHand1( 
			$this->draw( $this->getState()->getDeck1() ) 
		);
		
		// Mark state as updated
		$this->setState($this->getState());
	}
}
