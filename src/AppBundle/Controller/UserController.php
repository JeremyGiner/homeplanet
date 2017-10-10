<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Symfony\Component\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserController extends Controller {
	
	/**
	 * @Route("/user_account", name="account")
	 */
	public function accountAction( Request $request ) {
		
		// 
		$o = new \stdClass();
		$o->user = $this->getUser();
		// Build form
		$form = $this->createFormBuilder( $o )
			->setAction($this->generateUrl('login_check'))
			->add('_username', TextType::class, ['label' => 'Email'] )
			->add('password', RepeatedType::class, [
					'first_name' => 'password',
					'second_name' => 'confirm',
					'type' => 'password',
					'data' => 'password',
			])
			->add('passwordcurrent', TextType::class, ['label' => 'Current password'])
			->add('modif', SubmitType::class, ['label' => 'Modify'])
			->getForm();
		
		return $this->render('page/page_account.html.twig', [
				'form' => $form->createView(),
				'user' => $this->getUser(),
		]);
	
	}

//_____________________________________________________________________________

	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction( Request $request ) {
		/*
			// Check if user auth
			if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			return $this->redirectToRoute('index');
			}*/
	
		/* @var $authenticationUtils AuthenticationUtils */
		$authenticationUtils = $this->get('security.authentication_utils');
	
		// Check for auth error
		/* @var $error BadCredentialsException */
		$error = null;
		$error = $authenticationUtils->getLastAuthenticationError();
		if( $error !== null )
			$error = $error->getMessage();
	
		$lastUsername = $authenticationUtils->getLastUsername();
	
		//var_dump($lastUsername);
	
		// Build form
	
		$form = $this->createFormBuilder()
			->setAction($this->generateUrl('login_check'))
			->add('_username', TextType::class,  ['label' => 'Email'])
			->add('_password', PasswordType::class)
			->add('_target_path',HiddenType::class, ['data' => '/play' ] )
			->add('signin', SubmitType::class, ['label' => 'Sign in'])
			->getForm();
	
		if( $error !== null )
			$form->addError( new FormError( $error ) );
	
		return $this->render('page/page_login.html.twig', [
				'lastUsername' => $lastUsername,
				'form' => $form->createView()
		]);
	
	}
	
//_____________________________________________________________________________

	/**
	 * @Route( "/register", name="register"  )
	 */
	public function registerAction() {
	
	
		$form = $this->_getFormRegister();
		 
		return $this->render('page/page_register.html.twig', array(
				'date' => \date('d/m/Y H:i:s'),
				'form' => $form->createView(),
				'user' => $this->getUser(),
		));
	}

//_____________________________________________________________________________
	
	/**
	 * @Route( "/register_check", name="register_check"  )
	 */
	public function registerCheckAction( Request $request ) {
	
		$form = $this->_getFormRegister();
	
		$form->handleRequest( $request );
		
		if( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getEntityManager();
			
			$oUser = $form->getData();
			
			$encoder = $this->get('security.encoder_factory')
				->getEncoder($oUser);
			$passw = $encoder->encodePassword( 
					$oUser->getPassword(), 
					$oUser->getSalt() 
			);
			$oUser->setPassword($passw);
					
			$em->persist( $oUser );
			$em->flush();
			return $this->redirectToRoute('register_confirm');
		}
	
		return $this->render('page/page_register.html.twig', [
				'date' => \date('d/m/Y H:i:s'),
				'form' => $form->createView(),
				'user' => $this->getUser(),
		]);
	}
	
	/**
	 * @Route( "/register_confirm", name="register_confirm"  )
	 */
	public function registerConfirmAction() {
		return $this->render('page/page_alert.html.twig', [
				'date' => \date('d/m/Y H:i:s'),
				'alert' => [
						'header' => 'Register confirm',
						'content' => 'Register OK: email sent'
				],
				'user' => $this->getUser(),
		]);
	}
	
	
//_____________________________________________________________________________
//	SUb-routine
	
	
	protected function _getFormRegister() {
		return $this->createFormBuilder( new User(), ['data_class'=>'AppBundle\Entity\User'])
			->setAction($this->generateUrl('register_check'))
			->add('email', EmailType::class, [ 'label' => 'Email: ' ] )
			->add('password', RepeatedType::class, [
					'first_name' => 'password',
					'second_name' => 'confirm',
					'type' => PasswordType::class,
					'data' => 'password',
			])
			->add('signin', SubmitType::class, ['label' => 'Register'])
			->getForm();
	}
}
