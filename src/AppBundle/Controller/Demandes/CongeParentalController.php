<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeCongeParental;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\DemandeCongeParentalType;
use AppBundle\Service\DemandeService;

class CongeParentalController extends Controller
{
  /**
  * @Route("/juridique_rh/conge_parental", name="conge_parental")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $demandeConge = new DemandeCongeParental();
    $form = $this->createForm(DemandeCongeParentalType::class, $demandeConge, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
        array('flash' => "demande_lettre_mission.popupValidation.message")));
    }

    return $this->render('demandes/juridique_rh/conge_parental.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
