<?php
namespace homeplanet\Entity;

use homeplanet\Entity\Character;
use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\attribute\TurnDate;

/**
 * @ORM\Table(name="`characterhistory`")
 * @ORM\Entity
 */
class CharacterHistory {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="type")
	 */
	protected $_sType;
	
	/**
	 * @ORM\Column(type="symfony_serialized", name="param")
	 */
	protected $_aParam;
	
	/**
	 * @ORM\Column(type="integer", name="created")
	 */
	protected $_iCreated;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Character")
	 * @ORM\JoinTable(
	 *     name="character_characterhistory",
	 *     joinColumns={@ORM\JoinColumn(name="characterhistory_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aCharacter;
	
	const WEDDING_PROPOSAL = 'wedding_proposal';
	const CHILD_BIRTH = 'child_birth';
	const JOB_NEW = 'job_new';
	
//_____________________________________________________________________________
//	Constructor
	
	private function __construct( $aCharacter, $sType, $aParam, $iTurn ) {
		$this->_aCharacter = $aCharacter;
		$this->_sType = $sType;
		$this->_aParam = $aParam;
		$this->_iCreated = $iTurn;
		
		// TODO : validate param using type
	}
	
//_____________________________________________________________________________
//	Accessor

	public function getType() {
		return $this->_sType;
	}
	
	public function getParam( $sKey ) {
		if( ! isset( $this->_aParam[ $sKey ] ) )
			throw new \Exception('Key ['.$sKey.'] is not set as param');
		return $this->_aParam[ $sKey ];
	}
	
	public function getCreationDate() {
		return new TurnDate($this->_iCreated);
	}
	
//_____________________________________________________________________________
//	Constructor

	static public function STcreateTypeJobNew( 
		Character $oCharacter, 
		House $oHouse,
		$iTurn
	) {
		//TODO : add type of contract
		return new CharacterHistory(
			[$oCharacter], 
			self::JOB_NEW, 
			[
				'character' => $oCharacter,
				'house' => $oHouse,
			], 
			$iTurn
		);
	}
	
	static public function STcreateTypeWedding(
		Character $oProposer,
		Character $oProposed,
		$iTurn
	) {
		//TODO : add type of contract
		return new CharacterHistory(
			[$oProposer,$oProposed],
			self::WEDDING_PROPOSAL,
			[
				'proposer' => $oProposer,
				'proposed' => $oProposed,
			],
			$iTurn
		);
	}
	
	static public function STcreateTypeChildBirth(
		Character $oMother,
		Character $oFather,
		Character $oChild,
		$iTurn
	) {
		//TODO : add type of contract
		return new CharacterHistory(
			[$oMother,$oFather,$oChild],
			self::CHILD_BIRTH,
			[
				'mother' => $oMother,
				'father' => $oFather,
				'child' => $oChild,
			],
			$iTurn
		);
	}
}

