<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeLettreMission;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\DemandeLettreMissionType;
use AppBundle\Service\DemandeService;

class LettreMissionController extends Controller
{
  /**
  * @Route("/juridique_rh/lettremission", name="lettremission")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $demandeLettreMission = new DemandeLettreMission();
    $form = $this->createForm(DemandeLettreMissionType::class, $demandeLettreMission, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
        array('flash' => "lettre_mission.popupValidation.message")));

    }

    return $this->render('demande_lettre_mission.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
