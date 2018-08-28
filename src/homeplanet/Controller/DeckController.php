<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use homeplanet\Entity\Deck;
use homeplanet\Form\DeckForm;
use AppBundle\Tool\DoctrinePaginator;
use AppBundle\Tool\ArrayTool;

/**
 * @Route("/deck")
 */
class DeckController extends BaseController {
	
//_____________________________________________________________________________
//	Action
	
	/**
	 * Allow user to :
	 * - view equipped deck
	 * - view other deck
	 * - change deck
	 * - link to deck build
	 * @Route("", name="deck")
	 */
	public function mainAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oGame = $this->getGame();
		
		$aExpression = $this->getExpressionRepo()->findAll();
		$aDeck = $this->getDeckRepo()->findAllCommun();
		
		$oCharacter = $this->getGame()->getPlayer()->getCharacter();
		
		//_____________________________
		$form = $this->createFormBuilder()
			->add( 'deck', EntityType::class, [ 'class' => Deck::class, 'choices' => $aDeck ] )
			->add( 'submit', SubmitType::class, [ 'label' => 'Equip' ] )
			->getForm()
		;
		
		// Render
		return $this->render('homeplanet/page/deck.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'deck_current' => $oCharacter->getDeck(),
			'deckAr' => $aDeck,
			'form_equip' => $form,
			'character' => $oCharacter,
		]);
	}
	
	/**
	 * @Route("/create", name="deck_create")
	 */
	public function createAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oGame = $this->getGame();
		
		$gem = $oGame->getEntityManager();
		
		$oCharacter = $this->getGame()->getPlayer()->getCharacter();
		
		$iPage = $oRequest->get('page',1);
		$iPage = max( 1, $iPage );
		
		$oQuery = $this->getExpressionRepo()
			->createQueryBuilder('expression');
		
		
		$oPaginator = new DoctrinePaginator($oQuery, $iPage, 4);
		//$oPaginator = new Paginator( $oQuery );
		
		$aExpression = $oPaginator->getQuery()->getResult();
		
		//_____________________________
		// Form create
		
		$oFormCreate = $this->createForm(DeckForm::class, new Deck(), [
			'em' => $gem,
		] );
		
		$oFormCreate->handleRequest( $oRequest );
		
		if( $oFormCreate->isSubmitted() && $oFormCreate->isValid() ) {
			
			$gem->persist( $oFormCreate->getData() );
			$gem->flush();
			
			return $this->redirect($this->generateUrl('deck'));
		}
		
		//_____________________________
		// Render
		
		return $this->render('homeplanet/page/deck_create.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'form_create' => $oFormCreate->createView(),
			'expressionAr' => $aExpression,
			'expression_paginator' => $oPaginator,
		]);
	}
	
	
	/**
	 *
	 * @Route("/collection", name="deck_collection")
	 */
	public function expressionAction( Request $oRequest ) {
		
		
		//_____________________________
		//	filter
		
		$PAGE_LENGTH = 4;
		
		$iPage = $oRequest->get('page',1);
		$iPage = max( 1, $iPage );
		
		
		/*
		 # Update knowledge expression
		 INSERT IGNORE INTO knowledge ( knowledge.`id`,knowledge.`label`, knowledge.`type`, knowledge.reference)
		 SELECT id+10000,' ','expression', id FROM expression
		 */
		
		$this->_handleRequest( $oRequest );
		
		//______________________________
		//DEV
		//GENERATE expression
		/*
		 $em = $this->getGame()->getEntityManager();
		 
		 function array_cartesian() {
		 $_ = func_get_args();
		 if(count($_) == 0)
		 return array(array());
		 $a = array_shift($_);
		 $c = call_user_func_array(__FUNCTION__, $_);
		 $r = array();
		 foreach($a as $v)
		 foreach($c as $p)
		 $r[] = array_merge(array($v), $p);
		 return $r;
		 }
		 function get_type() {
		 static $a = [];
		 if( empty( $a ) ) {
		 $a = array( 0,1,2,3 );
		 }
		 $k = array_rand($a);
		 $v = $a[ $k ];
		 unset( $a[ $k ] );
		 return $v;
		 }
		 function get_score(
		 $aTail,
		 $iDebateGain,
		 $iPointGain,
		 $iPointGiven,
		 $bCounter
		 ) {
		 $i = 0;
		 $i += $iDebateGain * 10;
		 $i += $iPointGain * 20;
		 $i -= $iPointGiven * 30;
		 $i += ( $bCounter ) ? 50 : 0;
		 return $i;
		 }
		 function get_complexity(
		 $aTail,
		 $iDebateGain,
		 $iPointGain,
		 $iPointGiven,
		 $bCounter
		 ) {
		 $i = 0;
		 $i += $iDebateGain != 0 ? 1 : 0;
		 $i += $iPointGain != 0 ? 1 : 0;
		 $i += $iPointGiven != 0 ? 1 : 0;
		 $i += ( $bCounter ) ? 1 : 0;
		 return $i;
		 }
		 $aCombination = array_cartesian(
		 [// tail
		 [0,1],
		 [0,2],
		 [0,3],
		 [1,2],
		 [1,3],
		 [2,3],
		 [0,1,2],
		 [0,1,3],
		 [1,2,3],
		 ],
		 range(0,5),		// debate
		 range(-3,3),	// gain
		 range(-3,3),	// given
		 [true,false]	// counter
		 );
		 foreach( $aCombination as $a ) {
		 // Filter complexity
		 if( get_complexity($a[0], $a[1], $a[2], $a[3], $a[4]) > 3 )
		 continue;
		 
		 // Filter by score
		 $iScore = get_score($a[0], $a[1], $a[2], $a[3], $a[4]);
		 if( $iScore != 50 )
		 continue;
		 
		 $oExpresion = Expression::generateExpression(
		 get_type(),
		 $a[0], $a[1], $a[2], $a[3], $a[4]
		 );
		 
		 $em->persist( $oExpresion );
		 }
		 $em->flush();
		 */
		 
		 //_____________________________
		 
		 /**
		  * Persuade : 0
		  * Coerce : 1
		  * Passion : 2
		  * Charm : 3
		  */
		 /*
		  $oExpression = $this->getGame()->getEntityManager()
		  ->find(Expression::class, 8);
		  
		  $oExpression->setRequirement( new ValidatorAnd([
		  new TailRequire(3),
		  //new PointCost( 1, 2 ),
		  //new OpponentPointRequire(3, 5),
		  ]) );
		  //$oExpression->setRequirement( null );
		  
		  $oExpression->setEffect( [
		  //new Counter(),
		  
		  //new GivePoint(0, 1),
		  
		  //new AddPoint(0, 1),
		  //new AddPoint(1, 1),
		  //new AddPoint(2, 1),
		  //new AddPoint(3, 1),
		  
		  new AddTail([1,2,3]),
		  
		  //new ChangeLead(ChangeLead::GIVE),
		  //new Imitate(),
		  
		  new AddDebate(1),
		  
		  ] );
		  
		  $this->getGame()->getEntityManager()->flush();
		  
		  */
		
		
		//_____________________________
		
		$oExpressionRepo = $this->getExpressionRepo();
		
		//$aExpression = $oExpressionRepo->findAll();
		$oPaginator = new DoctrinePaginator(
			$oExpressionRepo->createQueryBuilder('expression'), 
			$iPage, 
			$PAGE_LENGTH
		);
		$aExpression = $oPaginator->getQuery()->getResult();
		
		$aExpression = ArrayTool::STindexBy($aExpression, 'id', true);
		
		$aOwnership = $oExpressionRepo->getIdByPlayerOwnership( $this->getGame()->getPlayer()->getId() );
		
		//_______
		
		return $this->render('homeplanet/page/expression_list.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'expressionAr' => $aExpression,
			'expressionOwnershipAr' => array_flip( $aOwnership ),
			'expression_paginator' => $oPaginator,
		]);
	}
	
	
//_____________________________________________________________________________
// Sub-routine


	
}

