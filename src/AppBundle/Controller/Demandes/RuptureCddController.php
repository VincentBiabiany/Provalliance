<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\DemandeRuptureCdd;
use AppBundle\Form\DemandeRuptureCddType;
use AppBundle\Service\DemandeService;

class RuptureCddController extends Controller
{
  /**
  * @Route("/juridique_rh/rupturecdd", name="rupture_cdd")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $demandeRupture = new DemandeRuptureCdd();
    $form = $this->createForm(DemandeRuptureCddType::class, $demandeRupture, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
        array('flash' => "___demande_rupture_cdd.popupValidation.message")));
    }

    return $this->render('demande_rupture_cdd.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
