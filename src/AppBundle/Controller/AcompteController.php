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
          $personnel = $form["idPersonnel"]->getData();

          $acompte->setMontant($montant)->setIdPersonnel($personnel->getId());
          $demande->setDemandeform($acompte);

          $em->persist($demande);
          $em->flush();
          $this->addFlash("success", "La demande d'acompte pour ".$personnel->getNom()." a correctement été envoyé !.\n Un mail vous sera envoyé une fois votre demande traité. ");

          return $this->redirectToRoute('homepage');
       }

        return $this->render('paie_acompte.html.twig', array(
                'form'=> $form->createView(),
            )
        );
    }
}
