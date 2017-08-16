<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Form\DemandeAcompteType;

class AcompteController extends Controller
{
    /**
     * @Route("/paie/acompte", name="acompte")
     */
    public function indexAction(Request $request)
    {
         $demandeacompte = new DemandeAcompte();
         $form = $this->createForm(DemandeAcompte::class, $demandeacompte);
        
        
        return $this->render('paie_acompte.html.twig', array('form'=> $form->createView()
        ));
    }
}
