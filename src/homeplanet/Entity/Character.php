<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\part\CharacterBody;
use homeplanet\Entity\part\CharacterState;
use Doctrine\ORM\EntityManager;

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
	 * @ORM\Column(type="integer", name="created")
	 * @var int
	 */
	protected $_iCreated;
	
	/**
	 * @ORM\Column(type="string", name="occupation")
	 */
	protected $_sOccupation;
	
	/**
	 * @ORM\Column(type="string", name="personality")
	 */
	protected $_sPersonality;
	
	/**
	 * @ORM\Column(type="string", name="appearance")
	 */
	protected $_sAppearance;
	
	/**
	 * @ORM\Column(type="string", name="seed")
	 */
	protected $_sSeed;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Knowledge")
	 * @ORM\JoinTable(
	 *     name="character_knowledge",
	 *     joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="knowledge_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aKnowledge;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Character")
	 * @ORM\JoinTable(
	 *     name="character_acquaintance",
	 *     joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="target_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aAcquaintance;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Expression")
	 * @ORM\JoinTable(
	 *     name="character_expression",
	 *     joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="expression_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aExpression;
	
	/**
	 * @ORM\OneToOne(targetEntity="\homeplanet\Entity\Deck")
	 * @ORM\JoinColumn(name="deck_id", referencedColumnName="id")
	 * @var Deck
	 */
	protected $_oDeck;
	
	/**
	 * @ORM\Column(type="simple_array", name="lifegoal")
	 * TODO : use doctrine ENUM ?
	 */
	protected $_aLifegoal;
	
	/**
	 * @ORM\OneToOne(targetEntity="\homeplanet\Entity\Character")
	 * @ORM\JoinColumn(name="mate_id", referencedColumnName="id")
	 * @var Character
	 */
	protected $_oMate;
	
	const LIFEGOAL_SELF_PRESERVE = 'self_preserve';
	const LIFEGOAL_FAMILY_CREATE = 'family_create';
	
	/**
	 * @ORM\Column(type="array", name="state")
	 * @var CharacterState
	 */
	protected $_oState;
	
	/**
	 * @ORM\Column(type="array", name="body")
	 * @var CharacterBody
	 */
	protected $_oBody;
	
	/**
	 * @ORM\OneToOne(targetEntity="\homeplanet\Entity\Pawn")
	 * @ORM\JoinColumn(name="pawn_id", referencedColumnName="id")
	 * @var Character
	 */
	protected $_oWorkplace;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\CharacterHistory")
	 * @ORM\JoinTable(
	 *     name="character_characterhistory",
	 *     joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="characterhistory_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aHistory;
	
	/**
	 * @ORM\Column(type="string", name="genre")
	 */
	protected $_sGenre;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( 
		EntityManager $em, 
		$sName, 
		$sGenre,
		CharacterBody $oBody = null
	) {
		if( $sName != null ) $this->_sLabel = $sName;
		$this->_sOccupation = 'merchant';
		$this->_sPersonality = 'TODO';
		$this->_sAppearance = 'TODO';
		$this->_oDeck = $em->getReference(Deck::class, 1);
		$this->_x = 0;//$oLocation->getX();
		$this->_y = 0;//$oLocation->getY();
		$this->_aLifegoal = [];
		$this->_iCreated = $em->getRepository(GameState::class)->find(1)->getTurn();//TODO: make game id #1 dynamic
		$this->_oBody = ( $oBody == null ) ? new CharacterBody() : $oBody;
		$this->_oWorkplace = null;
		$this->_sGenre = $sGenre;
	}
	
	static public function generate( 
		EntityManager $em, 
		$sLabel,
		$sGenre,
		Location $oLocation, 
		$sPlace
	) {
		$o = new Character(
			$em,
			$sLabel,
			$sGenre
		);
		
		$o->setLabel( $sLabel );
		$o->setLocation( $oLocation );
		
		// Set lifegoal
		$o->_aLifegoal = [Character::LIFEGOAL_SELF_PRESERVE, Character::LIFEGOAL_FAMILY_CREATE];
		
		// Set occupation
		$o->_sOccupation = self::_generate_occupation( $sPlace );
		
		// Set Deck
		$o->_oDeck = $em->getReference(Deck::class, 1);
		
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
	
	public function getDeck() {
		return $this->_oDeck;
	}
	
	public function getPersonality() {
		return $this->_sPersonality;
	}
	
	public function getExpressionAr() {
		return $this->_aExpression->toArray();
	}
	
	public function hasExpression( Expression $oExpression ) {
		
		if( $oExpression->getId() <= 3 ) return true;
		
		return $this->_aExpression->indexOf( $oExpression ) !== false;
	}
	
	public function getLocationX() {
		return $this->_x;
	}
	public function getLocationY() {
		return $this->_y;
	}
	
	
	public function getKnowledgeAr() {
		return $this->_aKnowledge->toArray();
	}
	
	/**
	 * @return Character[]
	 */
	public function getAcquaintanceAr() {
		return $this->_aAcquaintance->toArray();
	}
	
	public function getBody() {
		return $this->_oBody;
	}
	
	public function getCreated() {
		return $this->_iCreated;
	}
	
	public function getLifegoal() {
		return $this->_aLifegoal;
	}
	
	/**
	 * @return CharacterHistory[]
	 */
	public function getHistoryAr() {
		return $this->_aHistory->toArray();
	}
	
	public function getGenre() {
		return $this->_sGenre;
	}
	
	public function getOppositeGenre() {
		return $this->_sGenre == 'male' ? 'female' : 'male';
	}
	
	public function getMate() {
		return $this->_oMate;
	}
	
//_____________________________________________________________________________
//	Modifier

	public function setLabel( $s ) {
		$this->_sLabel = $s;
	}
	
	public function setDeck( Deck $o ) {
		$this->_oDeck = $o;
		return $this;
	}
	
	public function setLocation( $oLocation ) {
		$this->_x = $oLocation->getX();
		$this->_y = $oLocation->getY();
	}
	
	public function addDeckExpression( Expression $oExpression ) {
		$this->_aExpression->add($oExpression);
		return $this;
	}
	
	public function removeDeckExpression( Expression $oExpression ) {
		$this->_aExpression->removeElement( $oExpression );
		return $this;
	}
	
	public function addAcquaintance( Character $oCharacter ) {
		$this->_aAcquaintance->add($oCharacter);
		return $this;
	}
	
	public function setMate( Character $oCharacter ) {
		$this->_oMate = $oCharacter;
		return $this;
	}
	
	public function setWorkplace( Pawn $oPawn ) {
		$this->_oWorkplace = $oPawn;
		return $this;
	}
	
	public function setLifegoal( $aLifegoal ) {
		$this->_aLifegoal = $aLifegoal;
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
				'labourer' => 10,
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