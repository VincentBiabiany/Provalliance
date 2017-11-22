<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\DemandeAvenant;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\DemandeAvenantType;
use AppBundle\Service\DemandeService;

class AvenantController extends Controller
{
  /**
  * @Route("/juridique_rh/avenant", name="avenant")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $demandeAvenant = new DemandeAvenant();
    $form = $this->createForm(DemandeAvenantType::class, $demandeAvenant, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
        array('flash' => "___demande_avenant.popupValidation.message")));
    }

    return $this->render('demandes/juridique_rh/avenant.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
