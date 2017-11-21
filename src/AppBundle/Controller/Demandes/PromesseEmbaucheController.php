<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandePromesseEmbauche;
use AppBundle\Entity\Demande;
use AppBundle\Form\DemandePromesseEmbaucheType;
use AppBundle\Service\DemandeService;


class PromesseEmbaucheController extends Controller
{
  /**
  * @Route("/promesse_embauche", name="promesse_embauche")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    $DemandePromesseEmbauche = new DemandePromesseEmbauche();
    $form = $this->createForm(DemandePromesseEmbaucheType::class, $DemandePromesseEmbauche, array("idSalon" => $idSalon));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
      array('flash' => "___demande_promesse_embauche.popupValidation.message")));
      }


    return $this->render('demandes/juridique_rh/promesse_embauche.html.twig', array(
      'img' => $img,
      'form' => $form->createView(),
      'errors' => null
    ));
  }
}
