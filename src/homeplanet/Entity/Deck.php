<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;
use Doctrine\Common\Collections\Collection;
use homeplanet\validator\DeckValidator;

/**
 * @ORM\Table(name="deck")
 * @ORM\Entity(repositoryClass="homeplanet\Repository\DeckRepository")
 */
class Deck {
	
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
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Expression", fetch="EAGER")
	 * @ORM\JoinTable(
	 *     name="deck_expression",
	 *     joinColumns={@ORM\JoinColumn(name="deck_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="expression_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aExpression;
	
	const SIZE = 5;
	
//_____________________________________________________________________________
// Constructor
	
	public function __construct() {
		$this->_aExpression = new ArrayCollection();
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getExpressionAr() {
		return $this->_aExpression->toArray();
	}
	
	public function isPlayable() {
		return DeckValidator::STvalidate($this);
	}
	
//_____________________________________________________________________________
// Modifier

	public function setLabel( $sLabel ) {
		$this->_sLabel = $sLabel;
		return $this;
	}
	
	public function addExpression( Expression $oExpression ) {
		$this->_aExpression->add( $oExpression );
		return $this;
	}
	
	public function removeExpression( Expression $oExpression ) {
		$this->_aExpression->removeElement($oExpression);
		return $this;
	}
	
	public function setExpressionAr( $aExpression ) {
		$this->_aExpression->clear();
		foreach( $aExpression as $oExpression ) 
			$this->_aExpression->add($oExpression);
		return $this;
	}
	
}