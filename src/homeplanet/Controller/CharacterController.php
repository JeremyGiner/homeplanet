<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use homeplanet\Entity\Character;
use homeplanet\Entity\Conversation;
use homeplanet\Entity\Expression;
use homeplanet\tool\conversation\NpcBrain;
use AppBundle\Tool\ArrayTool;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use homeplanet\Entity\Player;
use homeplanet\Entity\KnowledgeCategory;
use homeplanet\Entity\Knowledge;
use homeplanet\Form\LocationType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use homeplanet\validator\character\CharacterMarryValidator;
use homeplanet\Entity\House;
use homeplanet\Entity\PawnFactory;
use homeplanet\Entity\PawnType;
use homeplanet\Entity\CharacterHistory;

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
		
		/**
		 * @var Character $oCharacter
		 */
		$oCharacter = $this->getCharacterRepo()->find( $id );
		if( $oCharacter == null ) throw $this->createNotFoundException('No character found');
		
		$oPlayerCharacter = $this->getPlayer()->getCharacter();
		
		// Form debate
		$oForm = $this->createFormBuilder()
			->getForm()
		;
		if( $oCharacter->getWorkplace() == null ) 
			$oForm->add('debate_hire', SubmitType::class, ['label' => 'Hire' ]);
		
		if( CharacterMarryValidator::STvalidate($this->getGame()->getState()->getTurn(),[$oPlayerCharacter, $oCharacter]) )
			$oForm->add('debate_marry', SubmitType::class, ['label' => 'Marry' ]);
		
		if( $oCharacter->getHouse() == $oPlayerCharacter->getHouse() && $oCharacter != $oPlayerCharacter )
			$oForm->add('disown', SubmitType::class, ['label' => 'Disown', 'attr' => [ 'class' => 'btn-danger' ] ]);
		
		if( $oCharacter->getHouse() == null )
			$oForm->add('debate_adopt', SubmitType::class, ['label' => 'Adopt' ]);
			
		$oForm->handleRequest( $oRequest );
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			// TODO
			
			/**
			 * @var Button $oButton
			 */
			$oButton = $oForm->getClickedButton();
			
			if( $oButton->isDisabled() )
				throw new \Exception('Action no longer available');
			
			// TODO : start debate
			switch( $oButton->getName() ) {
				case 'debate_hire' :
					if( $oCharacter->getWorkplace() != null ) 
						throw new \Exception();
					
					$gem = $this->getGame()->getEntityManager();
					
					
					$this->getPawnRepo()
						->createContract($this->getPlayer(), $oCharacter)
					;
					
					$gem->persist(CharacterHistory::STcreateTypeJobNew(
						$oCharacter, 
						$this->getPlayer()->getHouse(), 
						$this->getGame()->getState()->getTurn()
					));
					
					$gem->flush();
					return $this->redirect( $this->generateUrl('character_view',['id'=>$id]) );
				case 'debate_adopt' : 
					
					$oHouse = $this->getPlayer()->getHouse();
					$oCharacter->setHouse($oHouse);
					
					// TODO: create character history
					
					$this->getGame()->getEntityManager()->flush();
					
					return $this->redirect( $this->generateUrl('house_view',['id' => $oHouse->getId() ]));
					
				default :
					throw new \Exception('Not implemented yet'); //TODO
			}
		}
		
		// TODO : preload characters referenced by this character history
		/*
		foreach( $oCharacter->getHistoryAr() as $oHistory ) {
			if($oHistory->getType() == CharacterHistory::CHILD_BIRTH )
			var_dump( $oHistory->getParam('mother') );
		}
		exit();
		*/
		// Render
		//TODO : display house
		return $this->render('homeplanet/page/character_view.html.twig', [
				'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
				'character' => $oCharacter,
				'form' => $oForm->createView(),
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
			$oCharacter = $this->getCharacterRepo()->getRandom( 
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
			->add('house_label', TextType::class, ['label' => 'House name'] )
			->add('label', TextType::class, ['label' => 'Name'] )
			->add('skin_color', ChoiceType::class, [
				'label' =>'Skin color',
				'choices' => [
					'1' => '#FFDBAC',
					'2' => '#F1C27D',
					'3' => '#E0AC69',
					'4' => '#C68642',
					'5' => '#8D5524',
					//TODO: fill up
				],
			])
			->add('hair_color', ChoiceType::class, [
				'label' => 'Hair color',
				'choices' => [
'black' => '#090806',
'off black' => '#2C222B',
'darkest brown' => '#3B302A',
'mid dark brown' => '#4E433F',
'chestnut brown' => '#504444',
'light chestnut brown' => '#6A4E42',
'dark golden brown' => '#554838',
'light golden brown' => '#A98467',
'dark honey blonde' => '#B89778',
'bleached blonde' => '#DCD0BA',
'light ash blonde' => '#DEBC99',
'light ash brown' => '#977961',
'lightest blonde' => '#E6CEA8',
'pale golden blonde' => '#E5C8A8',
'strawberry blonde' => '#A56B46',
'light auburn' => '#91553D',
'dark auburn' => '#563B30',
'darkest grey' => '#71635A',
'medium grey' => '#B7A69E',
'light grey' => '#D6C4C2',
'white blonde' => '#FFF5E1',
'alabrum blonde' => '#CBBFB1',
'russet red' => '#8D4A42',
'terra cotta' => '#B6523A',
				],
			])
			->add('eye_color', ChoiceType::class, [
				'label' => 'Eye color',
				'choices' => [
					'brown' => '#9D723F',
					'green' => '#9ADA76',
					'blue' => '#7F92D7',
				],
			])
			->add('submit', SubmitType::class, ['label' => 'ok' ])
			->getForm()
		;
		
		$oForm->handleRequest( $oRequest );
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			
			// TODO : sanitize name
			$aData = $oForm->getData();
			
			$gem = $this->getGame()->getEntityManager();
			
			
			$oHouse = new House( $aData['house_label'] );
			$gem->persist( $oHouse );
			
			$oCharacter = new Character( $gem, $aData['label'], 'male', null, $oHouse );
			$gem->persist( $oCharacter );
			$gem->flush($oCharacter);
			
			$oPlayer = new Player( $this->getUser(), $oHouse );
			$oPlayer->setCharacter( $oCharacter );
			$gem->persist( $oPlayer );
			
			$gem->flush();
			
			return $this->redirect( $this->generateUrl('overview') );
			
		}
		
		return $this->render('homeplanet/page/character_create.html.twig', [
			'title' => 'Character creation',
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'form' => $oForm->createView(),
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

