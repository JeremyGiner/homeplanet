<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use homeplanet\Entity\Character;
use homeplanet\Entity\Conversation;
use homeplanet\modifier\conversation\Imitate;
use homeplanet\Entity\Expression;
use homeplanet\validator\ValidatorAnd;
use homeplanet\validator\PointCost;
use homeplanet\modifier\conversation\ChangeLead;
use homeplanet\modifier\conversation\AddPoint;
use homeplanet\modifier\conversation\GivePoint;
use homeplanet\validator\conversation\OpponentPointRequire;
use homeplanet\modifier\conversation\AddDebate;
use homeplanet\tool\conversation\NpcBrain;
use AppBundle\Tool\CartesianProduct;
use AppBundle\Tool\Combine;
use AppBundle\Tool\ArrayTool;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use homeplanet\Entity\Player;
use homeplanet\validator\conversation\TailRequire;
use homeplanet\modifier\conversation\AddTail;
use homeplanet\Entity\KnowledgeCategory;
use homeplanet\Entity\Knowledge;
use homeplanet\Form\LocationType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/character")
 */
class CharacterController extends BaseController {
	
//_____________________________________________________________________________
//	Action
	
	/**
	 * 
	 * @Route("", name="character")
	 */
	public function mainAction() {
		
	}
	
	
	/**
	 * Display character's info
	 * @Route("/{id}", name="character_view", requirements={"id": "\d+"})
	 */
	public function viewAction( $id, Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$oCharacter = $this->getGame()->getCharacterRepo()->find( $id );
		
		if( $oCharacter == null ) throw $this->createNotFoundException('No character found');
		
		// Form debate
		$oForm = $this->createFormBuilder()
			->add('submit',SubmitType::class, ['label' => 'TEST'])
			->getForm()
		;
		
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			//TODO
		}
		
		// Render
		return $this->render('homeplanet/page/character_view.html.twig', [
				'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
				'character' => $oCharacter,
		]);
	}
	
	/**
	 * Display character's info
	 * @Route("/acquaintance", name="character_acquaintance")
	 */
	public function acquaintanceAction( Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$aAquaintance = $this->getGame()->getPlayer()->getCharacter()->getAcquaintanceAr();
		
		//_____________________________
		// Meet form
		
		/* @var $oFormMeet Form */
		$oFormMeet = $this->createFormBuilder()
			->add('location', LocationType::class, [ 
				'game' => $this->getGame(), 
				'empty_data' => $this->getLocation(),
				'constraints' => [ new NotBlank() ],
			] )
			->add('submit',SubmitType::class, ['label' => 'Meet new charater'])
			->getForm()
		;
		
		$oFormMeet->handleRequest( $oRequest );
		if( $oFormMeet->isSubmitted() && $oFormMeet->isValid() ) {
			
			$em = $this->getGame()->getEntityManager();
			
			// Get character met
			$oCharacter = $this->getGame()->getCharacterRepo()->getRandom( 
				$oFormMeet->getData()['location'], 
				$this->getGame()->getPlayer()->getCharacter()->getId() 
			);
			
			$oConversation = new Conversation( 
				$this->getGame()->getPlayer()->getCharacter(),
				$this->getGame()->getPlayer()->getCharacter()->getDeck()->getExpressionAr(),
				
				$oCharacter,
				$oCharacter->getDeck()->getExpressionAr(),
				
				'meet'
			);
			$em->persist( $oConversation );
			$em->flush();
			
			return $this->redirect( $this->generateUrl('conversation_view',['id' => $oConversation->getId(),]));
		}
		
		//_____________________________
		// Render
		
		return $this->render('homeplanet/page/acquaintance.html.twig', [
				'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
				'characterList' => $aAquaintance,
				'form_meet' => $oFormMeet->createView(),
		]);
	}
	
	/**
	 * 
	 * @Route("/create", name="character_create")
	 */
	public function createAction( Request $oRequest ) {
		
		// Deny access
		if( $this->getUser()->getPlayer() !== null )
			throw new AccessDeniedException();
		
		$this->_handleRequest( $oRequest );
		
		$oForm = $this->createFormBuilder()
			->add('label', TextType::class, ['label' => 'Name'] )
			->add('submit', SubmitType::class, ['label' => 'ok' ])
			->getForm()
		;
		
		$oForm->handleRequest( $oRequest );
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			
			// TODO : sanitize name
			$aData = $oForm->getData();
			
			$gem = $this->getGame()->getEntityManager();
			$oCharacter = new Character( $gem, $aData['label'] );
			$gem->persist( $oCharacter );
			
			$oPlayer = new Player( $this->getUser() );
			$oPlayer->setCharacter( $oCharacter );
			$gem->persist( $oPlayer );
			
			$gem->flush();
			
			return $this->redirect( $this->generateUrl('overview') );
			
		}
		
		return $this->render('page/page_form.html.twig', [
			'title' => 'Character creation',
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'form' => $oForm->createView(),
		]);
	}
	
	/**
	 * 
	 * @Route("/expression", name="character_expression")
	 */
	public function expressionAction( Request $oRequest ) {
		
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
		
		$oExpressionRepo = $this->getGame()->getExpressionRepo();
		
		$aExpression = $oExpressionRepo->findAll();
		$aExpression = ArrayTool::STindexBy($aExpression, 'id', true);
		
		$aOwnership = $oExpressionRepo->getIdByPlayerOwnership( $this->getGame()->getPlayer()->getId() );
		
		$aDeck = $oExpressionRepo->getIdByPlayerDeck( $this->getGame()->getPlayer()->getId() );
		
		//_____________________________
		// Handle form add to deck
		
		$oFormAdd = $this->createNamedBuilder('deck_add')
			->add('expression',EntityType::class, [
				'class' => Expression::class,
				'choice_label' => false,
				'choices' => \array_map(function( $id ) use ( $aExpression ) { return $aExpression[ $id ]; }, $aOwnership)
			] )
			->add('submit', SubmitType::class, ['label' => '<<'])
			->getForm()
		;
		
		$oFormAdd->handleRequest( $oRequest );
		if( $oFormAdd->isSubmitted() && $oFormAdd->isValid() ) {
			/* @var $oExpression Expression */
			$oExpression = $oFormAdd->getData()['expression'];
			
			$this->getGame()->getPlayer()->getCharacter()->addDeckExpression($oExpression);
			$this->getGame()->getEntityManager()->flush();
			
			return $this->redirect($this->generateUrl('character_expression'));
		}
		
		//_____________________________
		// Handle form add to deck
		
		$oFormRemove = $this->createNamedBuilder('deck_remove')
			->add('expression',EntityType::class, [
				'class' => Expression::class,
				'choice_label' => false,
				'choices' => \array_map(function( $id ) use ( $aExpression ) { return $aExpression[ $id ]; }, $aOwnership)
			] )
			->add('submit', SubmitType::class, ['label' => '<<'])
			->getForm()
		;
		
		$oFormRemove->handleRequest( $oRequest );
		if( $oFormRemove->isSubmitted() && $oFormRemove->isValid() ) {
			/* @var $oExpression Expression */
			$oExpression = $oFormRemove->getData()['expression'];
			
			$this->getGame()->getPlayer()->getCharacter()->removeDeckExpression($oExpression);
			$this->getGame()->getEntityManager()->flush();
			
			return $this->redirect($this->generateUrl('character_expression'));
		}
		
		//_____________________________
		
		$aFormAddView = [];
		foreach( $oFormAdd->get('expression')->getConfig()->getOption('choices') as $key => $oExpression ) {
			$aFormAddView[ $oExpression->getId() ] = $oFormAdd->createView();
		}
		
		return $this->render('homeplanet/page/expression_list.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'expressionList' => $aExpression,
			'expressionOwnershipAr' => array_flip( $aOwnership ),
			'deck' => $aDeck,
			'formAddAr' => $aFormAddView,
		]);
	}
	
	/**
	 *
	 * @Route("/knowledge", name="character_knowledge")
	 */
	public function knowledgeAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$em = $this->getGame()->getEntityManager();
		
		$aCategory = $em->getRepository(KnowledgeCategory::class)->findAll();
		
		$aKnowledge = $em->getRepository(Knowledge::class)->findAll();
		$aKnowledge = ArrayTool::STindexBy( $aKnowledge, 'category.id');
		
		$aUnlocked = $this->getGame()->getPlayer()->getCharacter()->getKnowledgeAr();
		$aUnlocked = ArrayTool::STaggregate($aUnlocked, 'id');
		$aUnlocked = array_flip($aUnlocked);
		
		return $this->render('homeplanet/page/character_knowledge.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'knowledgeAr' => $aKnowledge,
			'unlockedAr' => $aUnlocked,
			'categoryAr' => $aCategory,
		]);
	}
	
	/**
	 * 
	 * @Route("/test_benchmark", name="test_benchmark")
	 */
	public function benchmarkAction( Request $oRequest ) {
		/*
		echo 'hello';
		echo ini_get('memory_limit');
		exit();
		*/
		$this->_handleRequest( $oRequest );
		$em = $this->getGame()->getEntityManager();
		
		
		$getExpr = function ( $id ) use ($em) { 
				$o = $em->find(Expression::class, $id);
				if( $o === null ) throw new \Exception($id.' invalid expression id');
				return $o;
		};
		// Get all deck combination (for a range of expression )
		/* @var $aDeckAr Expression[][] */
		/*
		$aDeckAr = ArrayTool::catesianProduct(array_map(function() use($getExpr) {
			return \array_map($getExpr, \range(1985,2236));
		}, \range(0, 8) ));
		*/
		\header("HTTP/1.1 200 Ok");
		echo 'prod carte : ';
		\ob_flush();
		
		//
		//$o = new CartesianProduct(array_map(function() use($getExpr) {
		//	return \array_map($getExpr, \range(1985,2236));
		//}, \range(0, 5) ));
		$o0 = new Combine(\array_map($getExpr, \range(1985,2000)), 4);
		$o1 = new Combine(\array_map($getExpr, \range(1985,2000)), 4);
		//$aDeckAr = $o->asArray();
		
		//
		$oCharacter0 = new Character();
		$oCharacter1 = new Character();
		
		//$c = count($aDeckAr);
		//$total = 250058907189001;//($c*$c);
		//$total = ( 2236 - 1985 ) * ( 2236 - 1985 - 1 ) * ( 2236 - 1985 - 2 ) * ( 2236 - 1985 - 3 ) * ( 2236 - 1985 - 4 );
		//echo 'total : '.$total;
		\ob_flush();
		//exit();
		$aStats = [];
		$iLoop = 0;
		foreach( $o0 as $aDeck0 ) 
		foreach( $o1 as $aDeck1 ) {
			
			echo implode( ';', \array_map(function( $o ){ return $o->getId(); }, $aDeck0) );
			echo ' vs ';
			echo implode( ';', \array_map(function( $o ){ return $o->getId(); }, $aDeck1) );
			echo "<br/>\n";
			\ob_flush();
			//continue;
			
			$aDeck0ById = ArrayTool::STindexBy($aDeck0, 'id', true);
			$aDeck1ById = ArrayTool::STindexBy($aDeck1, 'id', true);
			
			$oConversation = new Conversation(
					$oCharacter0, 
					$aDeck0ById, 
					$oCharacter1, 
					$aDeck1ById
			);
			
			$oWinner = null;
			foreach ( range(0,50) as $i ) {
				$oConversation->processExpression(
					NpcBrain::chooseConversationExpression( $oConversation, $oCharacter0, $aDeck0ById ),
					NpcBrain::chooseConversationExpression( $oConversation, $oCharacter1, $aDeck1ById )
				);
				
				$oWinner = $oConversation->getWinner();
				if( $oWinner !== null )
					break;
			}
			
			foreach( $aDeck0 as $oExpression ) {
				$id = $oExpression->getId();
				if( ! isset( $aStats[ $id ] ) )
					$aStats[ $id ] = ['w'=>0,'l'=>0,'d'=>0,'ID' => $oExpression->getLabel()];
				
				if( $oWinner === $oCharacter0 )
					$aStats[ $id ]['w']++;
				if( $oWinner === $oCharacter1 )
					$aStats[ $id ]['l']++;
				if( $oWinner === null )
					$aStats[ $id ]['d']++;
			}
			foreach( $aDeck1 as $oExpression ) {
				$id = $oExpression->getId();
				if( ! isset( $aStats[ $id ] ) )
					$aStats[ $oExpression->getId() ] = ['w'=>0,'l'=>0,'d'=>0,'ID' => $oExpression->getLabel()];
				
				if( $oWinner === $oCharacter1 )
					$aStats[ $id ]['w']++;
				if( $oWinner === $oCharacter0 )
					$aStats[ $id ]['l']++;
				if( $oWinner === null )
					$aStats[ $id ]['d']++;
			}
			
			$iLoop++;
			echo $iLoop."<br/>\n";
			
			\ob_flush();
			
			//if( $iLoop > 100 ) exit();
			
			\file_put_contents('benchmark', \json_encode( $aStats ) );
		}
		echo "END<br/>\n";
			
		\ob_flush();
		\file_put_contents('banchmark', \json_encode( $aStats) );
		
		exit();
	}
	
//_____________________________________________________________________________
// Sub-routine


	
}

