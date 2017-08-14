<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;
use homeplanet\Entity\part\ConversationContext;

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
	 * Member :
	 * - initiative : int character id
	 * - points : int[][] indexed by character id then by persuade(0), coerce(1), ...
	 * - log : 
	 * 
	 * @ORM\Column(type="array", name="state")
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
	/**
	 * State of the conversation
	 * @return array
	 * ['initiative'] int character id
	 * [points] int[][] indexed by character index then by persuade(0), coerce(1), ...
	 * [log] 
	 */
	public function getState() {
		return $this->_aState;
	}
	
	public function getCharacterIndex( Character $oCharacter ) {
		if( $oCharacter == $this->getCharacter0() ) return 0;
		if( $oCharacter == $this->getCharacter1() ) return 1;
		throw new Exception('Character is not in this conversation');
	}
	
//_____________________________________________________________________________
//	Modifier
	
	public function setState( array $aState ) {
		$this->_aState = $aState;
		return $this;
	}
	
	public function processExpression( Expression $oExp0, Expression $oExp1 ) {
				
		foreach( $oExp0->getEffectAr() as $oModifier )
			$oModifier->modify( new ConversationContext($this, $this->getCharacter0() ) );
		//$this->_aState = $oExp1->getEffect()->modify( $this );
		
		$this->_aState['log'][] = array( $oExp0->getId(), $oExp1->getId() );
	}
	
//_____________________________________________________________________________

	static public function getStateInitial() {
		return [
			'initiative' => 0,
			'point' => [
				0 => [ 0, 0, 0, 0 ],
				1 => [ 0, 0, 0, 0 ],
			],
			'log' => [],
		];
	}
}
