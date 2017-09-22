<?php
//TODO: include using composer https://github.com/bpolaszek/cartesian-product
//namespace BenTools\CartesianProduct;
namespace AppBundle\Tool;

use Countable;
use IteratorAggregate;

//TODO : find proper name
/**
 * foreach( (new Combine(\range(0,10), 3)) as $m ) {
			echo \implode(';', $m);
			echo "<br/>\n";
		}
 * @author JGINER
 *
 */
class Combine implements IteratorAggregate, Countable {
	/**
	 * @var array
	 */
	private $set = [];

	/**
	 * @var bool
	 */
	private $isRecursiveStep = false;

	/**
	 * @var int
	 */
	private $count;
	
	/**
	 * @var int
	 */
	private $_iRecursion = 1;
	
//_____________________________________________________________________________

	/**
	 * CartesianProduct constructor.
	 * @param array $set - A multidimensionnal array.
	 * @param int $i - Size of result
	 */
	public function __construct(array $set, $i ) {
		$this->set = $set;
		$this->_iRecursion = $i;
		if( $this->_iRecursion < 1 ) 
			throw new \Exception('Recusion must be >= 1; '.$this->_iRecursion.' given');
	}
	
//_____________________________________________________________________________

	/**
	 * @return \Generator
	 */
	public function getIterator() {
		if (empty($this->set)) {
			//throw new \Exception('empty set');
			yield[];
			return;
		}
		
		if( $this->_iRecursion == 1 ) {
			foreach( $this->set as $value ) {
				yield [ $value ];
			}
			return;
		}
		
		$a = array_merge($this->set,[]);//Clone
		
		//$keys = array_keys($a);
		//$key = end($keys);
		
		while ( !empty( $a ) ) {
			
			$mValue = array_pop($a);
			if( empty ($a ) ) return;
			$oSubSet = new self($a, $this->_iRecursion-1);
			foreach ( $oSubSet as $aSet ) {
				yield array_merge( [$mValue], $aSet );
			}
		}
	}

	/**
	 * @param $subset
	 * @param $key
	 */
	private function validate($subset, $key)
	{
		if (!is_array($subset) || empty($subset)) {
			throw new \InvalidArgumentException(sprintf('Key "%s" should return a non-empty array', $key));
		}
	}

	/**
	 * @return array
	 */
	public function asArray()
	{
		return iterator_to_array($this);
	}

	/**
	 * @return int
	 */
	public function count()
	{
		//TODO
		/*
		if (null === $this->count) {
			$this->count = (int) array_product(array_map(function ($subset, $key) {
				$this->validate($subset, $key);
				return count($subset);
			}, $this->set, array_keys($this->set)));
		}
		*/
		return $this->count;
	}
}
