<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\DemandeEmbaucheType;
use AppBundle\Entity\DemandeEmbauche;

class EmbaucheController extends Controller
{
    /**
     * @Route("/embauche", name="rh_embauche")
     */
    public function indexAction(Request $request)
    {
      $demandeEmbauche = new DemandeEmbauche();
      $form = $this->createForm(DemandeEmbaucheType::class, $demandeEmbauche, array('step' => '1'));
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          return $this->index2Action($request, $form->getData());
      }

      return $this->render('embauche.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView()
        )
      );
    }

    public function index2Action(Request $request, $demandeEmbauche)
    {
      $form = $this->createForm(DemandeEmbaucheType::class, $demandeEmbauche, array('step' => '2'));
      //$form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          //$this->index2Action($request);
      }

      return $this->render('embauche2.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView()
        )
      );
    }


}
