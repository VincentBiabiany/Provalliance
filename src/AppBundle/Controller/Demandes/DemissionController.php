<?php
namespace AppBundle\Controller\Demandes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeDemission;
use AppBundle\Entity\Demande;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\DemandeDemissionType;
use AppBundle\Service\DemandeService;


class DemissionController extends Controller
{
  /**
  * @Route("/demission", name="demission")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $DemandeDemission = new DemandeDemission();
    $form = $this->createForm(DemandeDemissionType::class, $DemandeDemission, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
      array('flash' => "demande_demission.popupValidation.message")));
      }


    return $this->render('demandes/juridique_rh/demission.html.twig', array(
      'img' => $img,
      'form' => $form->createView(),
      'errors' => null
    ));
  }
}
