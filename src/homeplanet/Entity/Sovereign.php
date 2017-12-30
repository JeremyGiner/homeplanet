<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\ProductionInputType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Population;
use homeplanet\tool\F;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
use homeplanet\Entity\attribute\EntityLocation;

/**
 * @ORM\Entity
 * @ORM\Table(name="sovereign")
 */
class Sovereign {
	
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
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Character")
	 * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
	 * @var Character
	 */
	protected $_oCharacter;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\City")
	 * @ORM\JoinColumn(name="capital", referencedColumnName="id")
	 * @var Entity
	 */
	protected $_oCapital;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\City")
	 * @ORM\JoinTable(
	 *     name="city_sovereign",
	 *     joinColumns={@ORM\JoinColumn(name="sovereign_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="city_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aCity;
	
	
	
//_____________________________________________________________________________
//	Constructor
	/*
	public function __construct( EntityType $oType ) {
		//$this->_iId 
		$this->_oType = $oType;
		$this->_aPosition = new ArrayCollection();
		$this->_aProduction = new ArrayCollection();
		$this->_aDemand = new ArrayCollection();
	}*/
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getCharacter() {
		return $this->_oCharacter;
	}
	
	public function getCapital() {
		return $this->_oCapital;
	}
	
	public function getColorPrimary() {
		
		$angle = $this->_colorTwist( $this->_iId ) * 2 * M_PI;
		
		return $this->lab2rgb(
			75, 
			cos( $angle )*200,
			sin( $angle )*200
		);
		
	}
	
	public function getColorSecondary() {
		$angle = $this->_colorTwist( $this->_iId+5 ) * 2 * M_PI;
		return $this->lab2rgb(
			25,
			cos( $angle )*200,
			sin( $angle )*200
		);
	}
	
	/**
	 * @return City[]
	 */
	public function getCityAr() {
		return $this->_aCity->toArray();
	}
	
	function _colorTwist( $iId ) {
		
		$iAlpha = 0;
		$iOmega = 1.0;
		$res = 0;
		
		$bin = decbin($iId);
		for( $i = 0; $i < strlen($bin) ; $i++ ) {
			//if() 
			$res = F::interpolate( $iAlpha, $iOmega, 0.5 );
			if( $bin[$i] == '0' ){
				$iAlpha = $res;
			} else {
				$iOmega = $res;
			}
		}
		
		return F::interpolate( $iAlpha, $iOmega, 0.5 );
	}
	
	//TODO: move elsewhere
	//http://www.easyrgb.com/index.php?X=MATH&H=01#text1
	function lab2rgb( $l_s, $a_s, $b_s ) {
		
		$R; $G; $B;
		$var_Y = ( $l_s + 16. ) / 116.;
		$var_X = $a_s / 500. + $var_Y;
		$var_Z = $var_Y - $b_s / 200.;
		
		if ( pow($var_Y,3) > 0.008856 ) 
			$var_Y = pow($var_Y,3);
		else
			$var_Y = ( $var_Y - 16. / 116. ) / 7.787;
		if ( pow($var_X,3) > 0.008856 ) 
			$var_X = pow($var_X,3);
		else
			$var_X = ( $var_X - 16. / 116. ) / 7.787;
		if ( pow($var_Z,3) > 0.008856 ) 
			$var_Z = pow($var_Z,3);
		else
			$var_Z = ( $var_Z - 16. / 116. ) / 7.787;
		
		$X = 95.047 * $var_X ;    //ref_X =  95.047     Observer= 2°, Illuminant= D65
		$Y = 100.000 * $var_Y;   //ref_Y = 100.000
		$Z = 108.883 * $var_Z ;    //ref_Z = 108.883
		
		// Convert XYZ => RGB
		
		$var_X = $X / 100. ;       //X from 0 to  95.047      (Observer = 2°, Illuminant = D65)
		$var_Y = $Y / 100. ;       //Y from 0 to 100.000
		$var_Z = $Z / 100. ;      //Z from 0 to 108.883
		
		$var_R = $var_X *  3.2406 + $var_Y * -1.5372 + $var_Z * -0.4986;
		$var_G = $var_X * -0.9689 + $var_Y *  1.8758 + $var_Z *  0.0415;
		$var_B = $var_X *  0.0557 + $var_Y * -0.2040 + $var_Z *  1.0570;
		
		if ( $var_R > 0.0031308 ) 
			$var_R = 1.055 * pow($var_R , ( 1 / 2.4 ))  - 0.055;
		else
			$var_R = 12.92 * $var_R;
		if ( $var_G > 0.0031308 ) 
			$var_G = 1.055 * pow($var_G , ( 1 / 2.4 ) )  - 0.055;
		else
			$var_G = 12.92 * $var_G;
		if ( $var_B > 0.0031308 ) 
			$var_B = 1.055 * pow( $var_B , ( 1 / 2.4 ) ) - 0.055;
		else
			$var_B = 12.92 * $var_B;
		
		return [
			max( min( round( $var_R * 255 ), 255 ), 0 ),
			max( min( round( $var_G * 255 ), 255 ), 0 ),
			max( min( round( $var_B * 255 ), 255 ), 0 ),
		];
	}

	
//_____________________________________________________________________________
//	Modifier
	
	public function addLocation( Location $oLoc ) {
		$this->_aPosition->add( new EntityLocation($this, $oLoc));
	}
	

}