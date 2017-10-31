<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;
use homeplanet\Entity\attribute\Location;
use homeplanet\Game;
use homeplanet\entity\TradeRouteFactory;
use homeplanet\Entity\MerchantFactory;
use homeplanet\Entity\Ressource;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 */
class DefaultController extends Controller {
	

//_____________________________________________________________________________
//	Action
	
	/**
	 * @Route("/", name="index")
	 */
	public function indexAction() {
	
		return $this->render('page/index.html.twig', array(
				'date' => \date('d/m/Y H:i:s'),
				'user' => $this->getUser(),
		));
	}
	
}
