<?php
namespace AppBundle\Controller\Demandes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeRib;
use AppBundle\Entity\Demande;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\DemandeRibType;
use AppBundle\Service\DemandeService;


class RibController extends Controller
{
  /**
  * @Route("/paie_rib", name="paie_rib")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $DemandeRib = new DemandeRib();
    $form = $this->createForm(DemandeRibType::class, $DemandeRib, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
      array('flash' => "demande_rib.popupValidation.message")));
      }


    return $this->render('demandes/paie/rib.html.twig', array(
      'img' => $img,
      'form' => $form->createView(),
      'errors' => null
    ));
  }
}
