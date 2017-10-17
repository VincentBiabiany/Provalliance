<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\DemandeAcompteType;

class AcompteController extends Controller
{
    /**
     * @Route("/paie/acompte", name="acompte")
     */
    public function indexAction(Request $request,\Swift_Mailer $mailer)
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
                    if (count($errors) > 0) {


                            $errorsString = (string) $errors;
                            return $this->render('paie_acompte.html.twig', array(
                                   'img' => $img,
                                   'form' => $form->createView(),
                                   'errors' => $errorsString
                               )
                            );


                        }else{

                            $demande = new DemandeSimple();
                            $acompte = new DemandeAcompte();
                            $em = $this->getDoctrine()->getManager();

                            $montant = $form["montant"]->getData();
                            $personnel = $form["idPersonnel"]->getData();

                            $acompte->setTypeForm("Demande d'acompte");
                            $acompte->setMontant($montant)->setIdPersonnel($personnel->getMatricule());

                            $demande->setService('paie');
                            $demande->setUser($this->getUser());
                            $demande->setIdSalon($idSalon);
                            $demande->setDemandeform($acompte);

                            $em->persist($demande);
                            $em->flush();

                            // Notification par Mail
                            $destinataire = $em->getRepository('AppBundle:User')->findOneBy(array('idPersonnel' => $personnel->getMatricule()));
                            // $destinataire = $destinataire->getEmail();

                            $user = $this->getUser();
                            $emetteur = $user->getEmail();

                            $message = (new \Swift_Message('Nouvelle demande d\'Acompte '))
                               ->setFrom('send@example.com')
                               ->setTo('recipient@example.com')
                               ->setBody(
                                   $this->renderView(
                                       'emails/demande_acompte.html.twig',
                                       array('personnel' => $personnel->getPrenom().' '.$personnel->getNom(),
                                              'user' => $user->getUsername(),
                                              'demande' => 'd\'acompte')
                                   ),
                                   'text/html'
                               );
                            $mailer->send($message);

                            $this->addFlash("success", "La demande d'acompte pour ".$personnel->getPrenom()." ".$personnel->getNom()." a correctement été envoyée ! Un mail vous sera envoyé une fois votre demande traitée.");
                            return $this->redirectToRoute('homepage');
                            }
                    }
       return $this->render('paie_acompte.html.twig', array(
              'img' => $img,
              'form' => $form->createView(),
              'errors' => null
          )
       );
    }
}
