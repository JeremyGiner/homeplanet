<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;
use homeplanet\Entity\part\ConversationContext;
use homeplanet\Entity\part\ConversationState;

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
	
	public function __construct() {
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
	 * State of the conversation
	 * @return ConversationState
	 */
	public function getState() {
		return $this->_aState[0];
	}
	
	public function getCharacterIndex( Character $oCharacter ) {
		if( $oCharacter == $this->getCharacter0() ) return 0;
		if( $oCharacter == $this->getCharacter1() ) return 1;
		throw new Exception('Character is not in this conversation');
	}
	
//_____________________________________________________________________________
//	Modifier
	
	public function setState( ConversationState $oState ) {
		$this->_aState = [ $oState ];
		return $this;
	}
	
	public function processExpression( Expression $oExp0, Expression $oExp1 ) {
				
		foreach( $oExp0->getEffectAr() as $oModifier )
			$oModifier->modify( new ConversationContext($this, $this->getCharacter0() ) );
		//$this->_aState = $oExp1->getEffect()->modify( $this );
		
		$this->_aState[0]->addLog($oExp0, $oExp1);
		$this->setState($this->_aState[0]);
	}
}
