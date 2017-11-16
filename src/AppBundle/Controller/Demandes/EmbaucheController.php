<?php

namespace AppBundle\Controller\Demandes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\DemandeEmbaucheType;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Entity\DemandeComplexe;
use AppBundle\Service\DemandeService;

class EmbaucheController extends Controller
{
    /**
     * @Route("/embauche", name="rh_embauche")
     */
    public function indexAction(Request $request)
    {
      $session = $request->getSession();
      $isSubmitted = false;
      if ($session->get('demande') != null) {
        $demandeEmbauche = $session->get('demande');
        $isSubmitted = true;
      } else {
        $demandeEmbauche = new DemandeEmbauche();
      }

      $form = $this->createForm(DemandeEmbaucheType::class, $demandeEmbauche, array('step' => '1'));

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $session = $request->getSession();
        $session->set('demande', $form->getData());
        return $this->redirectToRoute('rh_embauche2');
      }

      return $this->render('embauche.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView(),
        'isSubmitted' => $isSubmitted
        )
      );
    }

    /**
     * @Route("/embauche2", name="rh_embauche2")
     */
    public function index2Action(Request $request)
    {
      $session = $request->getSession();
      $demande = $session->get('demande');
      //$demande->setTempsPartiel();
      $form = $this->createForm(DemandeEmbaucheType::class, $demande, array('step' => '2'));

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
       $session->set('demande', $form->getData());

       return $this->redirectToRoute('rh_embauche3');
      }

      return $this->render('embauche2.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView()
        )
      );
    }

    /**
     * @Route("/clearSession", name="clearSession")
     */
     public function indexClearSession(Request $request) {
       self::clearSession($request);
       return new Response(json_encode("ok"), 200, ['Content-Type' => 'application/json']);
     }

     public function clearSession($request) {

       $session = $request->getSession();
       $session->remove('demande');
       $session->remove('nat');
       $session->remove('poste');
       $session->remove('diplome');
       $session->remove('date');
     }

    /**
     * @Route("/embauche3", name="rh_embauche3")
     */
    public function index3Action(Request $request, DemandeService $demandeService)
    {
      $session = $request->getSession();
      $form = $this->createForm(DemandeEmbaucheType::class, $session->get('demande'), array('step' => '3'));

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $demandeService->createDemande($form->getData(), $request->getSession()->get('idSalon'));
        self::clearSession($request);
        return $this->redirect($this->generateUrl('homepage',
                array('flash' => "demande_embauche.popupValidation.message")));
        }

      return $this->render('embauche3.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView()
        )
      );
    }
}
