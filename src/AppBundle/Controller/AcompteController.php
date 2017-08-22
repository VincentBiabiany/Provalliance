<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\Demande;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\DemandeAcompteType;

class AcompteController extends Controller
{
    /**
     * @Route("/paie/acompte", name="acompte")
     */
    public function indexAction(Request $request)
    {
        $demandeacompte = new DemandeAcompte();
        $form = $this->createForm(DemandeAcompteType::class, $demandeacompte);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          $demande = new Demande();
          $acompte = new DemandeAcompte();
          $em = $this->getDoctrine()->getManager();

          $montant = $form["montant"]->getData();
          $personnel = $form["personnel"]->getData();

          $acompte->setMontant($montant)->setPersonnel($personnel->getId());
          $demande->setTypeform($acompte);

          $em->persist($demande);
          $em->flush();

          return $this->redirectToRoute('homepage');
       }
       /*$acompte = new DemandeAcompte();
        $acompte->setMontant(250)->setPersonnel(1);*/
        //
        // $ribsalarie = new RibSalarie();
        // $ribsalarie->setRib(1)->setPersonnel(6);
        //
        // $demande = new Demande();
        // // $demande->setTypeform($acompte);
        // $demande->setTypeform($ribsalarie);
        // $em = $this->getDoctrine()->getManager();
        //
        // $em->persist($demande);
        // $em->flush();

        return $this->render('paie_acompte.html.twig', array(
                'form'=> $form->createView(),
            )
        );
    }
}
