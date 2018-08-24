<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="house")
 * @ORM\Entity
 */
class House {
	
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
	 * @ORM\OneToMany(
	 *     targetEntity="\homeplanet\Entity\Character",
	 *     mappedBy="_oHouse"
	 * )
	 * @var ArrayCollection
	 */
	protected $_aCharacter;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $sLabel ) {
		$this->_sLabel = $sLabel;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	/**
	 * 
	 * @return Character[]
	 */
	public function getCharacterAr() {
		return $this->_aCharacter->toArray();
	}
	
	public function getMaleSortedByAgeInc() {
		$a = [];
		foreach ( $this->getCharacterAr() as $oCharacter ) {
			if( $oCharacter->getGenre() != 'male' )
				continue;
			$a[] = $oCharacter;
		}
		usort( $a, function( Character $a, Character $b ) {
			return ($a->getDateCreated() < $b->getDateCreated()) ? -1 : 1;
		});
		return $a;
	}
	
	public function getFemaleSortedByAgeDesc() {
		$a = [];
		foreach ( $this->getCharacterAr() as $oCharacter ) {
			if( $oCharacter->getGenre() != 'female' )
				continue;
			$a[] = $oCharacter;
		}
		usort( $a, function( Character $a, Character $b ) {
			return ($a->getDateCreated() < $b->getDateCreated()) ? -1 : 1;
		});
		return $a;
	}
	
//_____________________________________________________________________________
//	Modifier

	
	public function add( Character $oCharacter ) {
		$this->_aCharacter->add( $oCharacter );
		return $this;
	}
}