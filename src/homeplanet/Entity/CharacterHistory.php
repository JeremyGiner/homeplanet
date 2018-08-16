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
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $aCharacter, $sType, $aParam, $iTurn ) {
		$this->_aCharacter = $aCharacter;
		$this->_sType = $sType;
		$this->_aParam = $aParam;
		$this->_iCreated = $iTurn;
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
}

