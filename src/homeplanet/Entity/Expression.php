<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;
use homeplanet\validator\ValidatorAnd;
use homeplanet\validator\PointCost;
use homeplanet\validator\conversation\TailRequire;
use homeplanet\modifier\conversation\Counter;
use homeplanet\modifier\conversation\AddDebate;
use homeplanet\modifier\conversation\AddTail;
use homeplanet\modifier\conversation\AddPoint;
use homeplanet\modifier\conversation\GivePoint;

/**
 * @ORM\Table(name="expression")
 * @ORM\Entity(repositoryClass="homeplanet\Repository\ExpressionRepository")
 */
class Expression {
	
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
	 * @ORM\Column(type="string", name="description")
	 */
	protected $_sDescription;
	
	/**
	 * @ORM\Column(type="object", name="requirement")
	 * @var IValidator
	 */
	protected $_oRequirement;
	
	/**
	 * @ORM\Column(type="object", name="effect")
	 * 
	 */
	protected $_aEffect;
	
	/**
	 * @ORM\Column(type="string", name="generation_key")
	 *
	 */
	protected $_sGenerationKey = null;
	
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
	}
	
	static public function generateExpression(
			$iType,
			$aTail,
			$iDebateGain,
			$iPointGain,
			$iPointGiven,
			$bCounter
	) {
		$o = new Expression();
		$o->_sGenerationKey = implode(';',[
				$iType,
				implode('|',$aTail),
				$iDebateGain,
				$iPointGain,
				$iPointGiven,
				$bCounter,
		]);
		$o->_sLabel = $o->_sGenerationKey;
		$o->_sDescription = $o->_sGenerationKey;
		
		$o->setRequirement(new ValidatorAnd([
			new TailRequire($iType),
		]));
		
		$aEffect = [
				//new Counter(),
				//new AddPoint(1, -3),
				//new GivePoint(0, 1),
				//new AddPoint(0, 1),
					
				//new AddPoint(3, -1),
				//new ChangeLead(ChangeLead::GIVE),
				//new Imitate(),
					
				//new AddDebate(10),
			new AddTail($aTail),
		];
		
		if( $bCounter )
			$aEffect[] = new Counter();
		if( $iDebateGain != 0 )
			$aEffect[] = new AddDebate($iDebateGain);
		if( $iPointGain != 0 )
			$aEffect[] = new AddPoint($iType,$iPointGain);
		if( $iPointGiven != 0 )
			$aEffect[] = new GivePoint($iType,$iPointGiven);
		
		$o->setEffect( $aEffect );
		
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
	
	public function getDescription() {
		return $this->_sDescription;
	}
	
	public function getEffectAr() {
		return $this->_aEffect;
	}
	
	public function getRequirement() {
		return $this->_oRequirement;
	}
	
	public function getAddDebate() {
		foreach( $this->getEffectAr() as $oEffect ) {
			if( $oEffect instanceof AddDebate ) return $oEffect;
		}
		return null;
	}
	public function getAddDebateValue() {
		$oAddDebate = $this->getAddDebate();
		if( $oAddDebate === null )
			return null;
		return $oAddDebate->getValue();
	}
	
	public function getTailRequire() {
		if( ! $this->_oRequirement instanceof ValidatorAnd ) return null;
		foreach( $this->_oRequirement->getValidatorAr() as $oValidator ) {
			if( $oValidator instanceof TailRequire )
				return $oValidator;
		}
		return null;
	}
	public function getTailRequireType() {
		$oTailRequire = $this->getTailRequire();
		if( $oTailRequire === null )
			return null;
		//else 
		return $oTailRequire->getType();
	}
	
//_____________________________________________________________________________
//	Modifier

	public function setRequirement( $o ) {
		$this->_oRequirement = $o;
	}
	public function setEffect( array $a ) {
		$this->_aEffect = $a;
	}
}