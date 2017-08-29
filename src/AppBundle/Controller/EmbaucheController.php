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
      $form = $this->createForm(DemandeEmbaucheType::class, $demandeEmbauche);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          // ... save the meetup, redirect etc.
      }


      return $this->render('embauche.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView()
        )
      );
    }
}
