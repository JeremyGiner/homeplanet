<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="`character`")
 * @ORM\Entity(repositoryClass="homeplanet\Repository\CharacterRepository")
 */
class Character {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 */
	protected $_sLabel;
	
	/**
	 * @ORM\Column(type="integer", name="location_x")
	 * @var int
	 */
	protected $_x;
	
	/**
	 * @ORM\Column(type="integer", name="location_y")
	 * @var int
	 */
	protected $_y;
	
	/**
	 * @ORM\Column(type="string", name="occupation")
	 * @var array
	 */
	protected $_sOccupation;
	
	/**
	 * @ORM\Column(type="string", name="personality")
	 * @var array
	 */
	protected $_sPersonality;
	
	/**
	 * @ORM\Column(type="string", name="appearance")
	 * @var array
	 */
	protected $_sAppearance;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Knowledge")
	 * @ORM\JoinTable(
	 *     name="character_knowledge",
	 *     joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="knowledge_id", referencedColumnName="id")}
	 * )
	 * @var Collection
	 */
	protected $_aKnowledge;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Expression")
	 * @ORM\JoinTable(
	 *     name="character_expression",
	 *     joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="expression_id", referencedColumnName="id")}
	 * )
	 * @var Collection
	 */
	protected $_aExpression;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
	}
	
	static public function generate( Location $oLocation, $sPlace ) {
		$o = new Character();
		
		$o->_x = 0;//$oLocation->getX();
		$o->_y = 0;//$oLocation->getY();
		
		
		// Get occupation
		$o->_sOccupation = self::_generate_occupation( $sPlace );
		
		// Get appearance
		//TODO
		
		// Get personality
		//TODO
		
		// Get knowledge
		//TODO
		
		// Get expression
		//TODO
		
		return $o;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getPersonality() {
		return $this->_sPersonality;
	}
	
	public function getExpressionAr() {
		return $this->_aExpression->toArray();
	}
	
	
	public function getKnowledgeAr() {
		return $this->_aKnowledge->toArray();
	}
	
	
//_____________________________________________________________________________
//	Modifier

	public function setDeck( array $aExpression ) {
		foreach( $aExpression as $oExpression )
			$this->_aExpression->add( $oExpression );
		return $this;
	}
	
	public function addDeckExpression( Expression $oExpression ) {
		$this->_aExpression->add($oExpression);
		return $this;
	}
	
	public function removeDeckExpression( Expression $oExpression ) {
		$this->_aExpression->removeElement( $oExpression );
		return $this;
	}
	
//_____________________________________________________________________________
//	Sub-routine

	static protected function _generate_occupation( $sBiome ) {
		$a = [
			'sea' => [
				'fisherman' => 1,
			],
			'desert' => [
				'traveler' => 1,
			],
			'forest' => [
				'traveler' => 1,
				'lumberjack' => 1,
			],
			'plain' => [
				'traveler' => 1,
				'farmer' => 2,
			],
			'mountain' => [
				'traveler' => 1,
			],
			'city' => [
				'traveler' => 1,
				'merchant' => 10,
				'worker' => 10,
				'soldier' => 5,	//TODO: depend on city security
				'spy' => 1,
			],
		];
		$sum = array_sum( $a[ $sBiome ] ); 
		$iRand = rand( 0, $sum );
		
		$i = 0;
		foreach ( $a[ $sBiome ] as $sOccupation => $iStat ) {
			if( $iRand >= $i && $iRand <= $i+$iStat )
				return $sOccupation;
			$i += $iStat;
		}
		throw new \Exception();
	}
	static protected function _generate_knowledge( $sBiome, Character $oCharacter ) {
		/*
		
		interest = agro
		type : 
			'gossip',	// low interest, scope local
			'rumor',	// medium interest, scope local
			'news',		// medium interest, scope region
			'secret'	// high interest, scope precise
			
			'story',			// lore
			'contact',			// create character/unlock chracter info
			
			'recipe',			// affect culture
			'science',			
			'military plan',	// affect military
		difficulity :
			difficulty to exchange
		expiration date
		
		
		*/
		$a = [
			'gossip',
			'news',
			'rumor',
			'story',
			'contact',
			'recipe',
			'military plan',
		];
	}
}