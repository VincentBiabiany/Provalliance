<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Entity\DemandeAttestationSalaire;
use AppBundle\Form\DemandeAttestationSalaireType;
use AppBundle\Service\DemandeService;

class AttestationSalaireController extends Controller
{
  /**
  * @Route("/paie/attestation_salaire", name="attestation_salaire")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $attestationsalaire = new DemandeAttestationSalaire();
    $form = $this->createForm(DemandeAttestationSalaireType::class, $attestationsalaire, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $validator = $this->get('validator');
      $errors = $validator->validate($form);

      // Contrôle des erreurs
      if (count($errors) > 0) {

        $errorsString = (string) $errors;
        return $this->render('demandes/paie/attestation_salaire.html.twig',
                            array(
                              'img' => $img,
                              'form' => $form->createView(),
                              'errors' => $errorsString
                            )
                          );
      } else {

        $demandeService->createDemande($form->getData(), $idSalon);

        return $this->redirect($this->generateUrl('homepage',
        array('flash' => "___demande_attestation_salaire.popupValidation.message")));

      }
    }

    return $this->render('demandes/paie/attestation_salaire.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
