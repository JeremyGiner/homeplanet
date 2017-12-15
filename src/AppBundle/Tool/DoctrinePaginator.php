<?php
namespace AppBundle\Tool;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 *
 */
class DoctrinePaginator extends Paginator {
	
	private $_iPage;
	private $_iPageSize;
	
//_____________________________________________________________________________

	/**
	 */
	public function __construct( $oQuery, $iPage, $iPageSize ) {
		$this->_iPage = $iPage;
		$this->_iPageSize = $iPageSize;
		
		$oQuery
			->setFirstResult($this->_iPageSize * ($this->_iPage - 1) )
			->setMaxResults($this->_iPageSize)
		;
		parent::__construct( $oQuery );
		
	}
	
//_____________________________________________________________________________
// Accessor

	public function getPage() {
		return $this->_iPage;
	}
	
	public function getPageMax() {
		return ceil( $this->count() / $this->_iPageSize );
	}

}
