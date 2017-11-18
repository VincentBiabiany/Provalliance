<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DemandeAbsencesInjustifieesType;
use AppBundle\Service\DemandeService;
use AppBundle\Entity\DemandeAbsencesInjustifiees;


class AbsencesInjustifieesController extends Controller
{
  /**
  * @Route("/juridique_rh/absences_injustifiees", name="absences_injustifiees")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $demandeAbs = new DemandeAbsencesInjustifiees();
    $form = $this->createForm(DemandeAbsencesInjustifieesType::class, $demandeAbs, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
        array('flash' => "absences.popupValidation.message")));
    }

    return $this->render('demandes\juridique_rh\absences_injustifiees.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
