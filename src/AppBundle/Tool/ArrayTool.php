<?php
namespace AppBundle\Tool;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;

class ArrayTool {
	
	/**
	 * @var PropertyAccess
	 */
	protected $accessor;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
		$this->accessor = PropertyAccess::createPropertyAccessor();
	}
	
//_____________________________________________________________________________
//	

	public function aggregate( $mSubject, $sPropertyPath ) {

		// Format property path
		$a = explode( '[]', $sPropertyPath );
		$aPopertyPath = [];
		foreach( $a as $s ) {
			
			if( $s == '' ) {
				$aPopertyPath[] = null;
				continue;
			}
			
			if( $s[0] === '.' )
				$s = substr($s, 1);
				
			$aPopertyPath[] = new PropertyPath($s);
		}
		
		// Extract aggregate
		$mSubjectCurrent = $mSubject;
		end($a);
		$lastKey = key($a);
		foreach( $aPopertyPath as $key => $oPopertyPath ) {
				
			if( $oPopertyPath === null ) {
				//$mSubjectCurrent = $mSubjectCurrent;
				continue;
			}
				
			$aTmp = [];
			foreach ( $mSubjectCurrent as $o ) {
				$v = $this->accessor->getValue($o, $oPopertyPath);
		
				if( $lastKey === $key )
					$aTmp[] = $v;
				else
					$aTmp = array_merge( $v, $aTmp );
			}
				
			$mSubjectCurrent = $aTmp;
		}
		
		return $mSubjectCurrent;
	}
	
	public function indexBy( array $aSubject, $sPropertyPath ) {
		
		$oPropertyPath = new PropertyPath( $sPropertyPath );
		
		$a = [];
		foreach ( $aSubject as $m ) {
			$key = $this->accessor->getValue($m, $oPropertyPath);
			
			//TODO check if $key can be index of array
			
			$a[ $key ][] = $m;
		}
		return $a;
	}
	
//_____________________________________________________________________________

	/**
	 * Short hand for aggregate
	 * @param unknown $mSubject
	 * @param string $sPropertyPath
	 */
	public static function STaggregate( $mSubject, $sPropertyPath ) {
		$o = new ArrayTool();
		
		return $o->aggregate($mSubject, $sPropertyPath);
		
	}
	
	/**
	 * Short hand for aggregate
	 * @param array $mSubject
	 * @param string $sPropertyPath
	 */
	public static function STindexBy( array $aSubject, $sPropertyPath ) {
		$o = new ArrayTool();
		
		return $o->indexBy( $aSubject, $sPropertyPath);
	}
}