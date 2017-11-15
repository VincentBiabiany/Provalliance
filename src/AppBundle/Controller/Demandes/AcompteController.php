<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\DemandeAcompteType;
use AppBundle\Service\DemandeService;

class AcompteController extends Controller
{
  /**
  * @Route("/paie/acompte", name="acompte")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $demandeacompte = new DemandeAcompte();
    $form = $this->createForm(DemandeAcompteType::class, $demandeacompte, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $validator = $this->get('validator');
      $errors = $validator->validate($form);

      // Contrôle des erreurs
      if (count($errors) > 0) {

        $errorsString = (string) $errors;
        return $this->render('paie_acompte.html.twig',
                            array(
                              'img' => $img,
                              'form' => $form->createView(),
                              'errors' => $errorsString
                            )
                          );
      } else {

        $demandeService->createDemande($form->getData(), $idSalon);

        return $this->redirect($this->generateUrl('homepage',
        array('flash' => "demande_acompte.popupValidation.message")));

      }
    }

    return $this->render('demandes/paie/acompte.html.twig', array(
                                                  'img' => $img,
                                                  'form' => $form->createView(),
                                                  'errors' => null
                                                )
                                              );
  }
}
