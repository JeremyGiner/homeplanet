<?php
//TODO: include using composer https://github.com/bpolaszek/cartesian-product
//namespace BenTools\CartesianProduct;
namespace AppBundle\Tool;

use Countable;
use IteratorAggregate;

//TODO : find proper name
class Combine implements IteratorAggregate, Countable
{
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

	/**
	 * CartesianProduct constructor.
	 * @param array $set - A multidimensionnal array.
	 * @param int $i - Size of result
	 */
	public function __construct(array $set, $i )
	{
		$this->set = $set;
		$this->_iRecursion = $i;
		if( $this->_iRecursion < 1 ) 
			throw new \Exception('Recusion must be >= 1; '.$this->_iRecursion.' given');
	}

	/**
	 * @return \Generator
	 */
	public function getIterator() {
		if (empty($this->set)) {
			if (true === $this->isRecursiveStep) {
				yield [];
			}
		}
		
		if( $this->_iRecursion == 1 ) {
			foreach( $this->set as $value ) {
				yield [ $value ];
			}
			return;
		}
		
		$a = $this->set+[];//Clone
		
		//$keys = array_keys($a);
		//$key = end($keys);
		$ref_value = array_pop($a);
		
		//$this->validate($subset, $key);
		foreach (self::subset( $a, $this->_iRecursion-1 ) as $product)  {
			yield array_merge( [$ref_value], $product );
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
	 * @param array $subset
	 * @return CartesianProduct
	 */
	private static function subset(array $subset, $i )
	{
		$product = new self($subset, $i);
		$product->isRecursiveStep = true;
		return $product;
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
		if (null === $this->count) {
			$this->count = (int) array_product(array_map(function ($subset, $key) {
				$this->validate($subset, $key);
				return count($subset);
			}, $this->set, array_keys($this->set)));
		}
		return $this->count;
	}
}
