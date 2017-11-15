<?php
namespace AppBundle\Controller\Demandes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeRupturePeriodeEssai;
use AppBundle\Entity\Demande;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\DemandeRupturePeriodeEssaiType;
use AppBundle\Service\DemandeService;


class RupturePeriodeEssaiController extends Controller
{
  /**
  * @Route("/rupture_periode_essai", name="rupture_periode_essai")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $DemandeRupturePeriodeEssai = new DemandeRupturePeriodeEssai();
    $form = $this->createForm(DemandeRupturePeriodeEssaiType::class, $DemandeRupturePeriodeEssai, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
      array('flash' => "demande_rupture_periode_essai.popupValidation.message")));
      }


    return $this->render('demandes/juridique_rh/rupture_periode_essai.html.twig', array(
      'img' => $img,
      'form' => $form->createView(),
      'errors' => null
    ));
  }
}
