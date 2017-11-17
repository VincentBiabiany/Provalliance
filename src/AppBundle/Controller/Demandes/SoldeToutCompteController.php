<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Form\DemandeSoldeToutCompteType;
use AppBundle\Entity\DemandeSoldeToutCompte;
use AppBundle\Service\DemandeService;

class SoldeToutCompteController extends Controller
{
  /**
  * @Route("/paie/solde_tout_compte", name="solde_tout_compte")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $DemandeSoldeToutCompte = new DemandeSoldeToutCompte();
    $form = $this->createForm(DemandeSoldeToutCompteType::class, $DemandeSoldeToutCompte, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $validator = $this->get('validator');
      $errors = $validator->validate($form);

      // Contrôle des erreurs
      if (count($errors) > 0) {

        $errorsString = (string) $errors;
        return $this->render('demandes/paie/solde_tout_compte.html.twig',
                            array(
                              'img' => $img,
                              'form' => $form->createView(),
                              'errors' => $errorsString
                            )
                          );
      } else {

        $demandeService->createDemande($form->getData(), $idSalon);

        return $this->redirect($this->generateUrl('homepage',
        array('flash' => "demande_solde_tout_compte.popupValidation.message")));

      }
    }

    return $this->render('demandes/paie/solde_tout_compte.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
