<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
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
      $demandeEmbauche = new DemandeEmbauche();
      $form = $this->createForm(DemandeEmbaucheType::class, $demandeEmbauche, array('step' => '1'));

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $session = $request->getSession();
        $session->set('demande', $form->getData());
        return $this->redirectToRoute('rh_embauche2');
      }

      return $this->render('embauche.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView()
        )
      );
    }
    /**
     * @Route("/embauche2", name="rh_embauche2")
     */
    public function index2Action(Request $request)
    {
      $session = $request->getSession();
      $form = $this->createForm(DemandeEmbaucheType::class, $session->get('demande'), array('step' => '2'));

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
     * @Route("/embauche3", name="rh_embauche3")
     */
    public function index3Action(Request $request, DemandeService $demandeService)
    {
      $session = $request->getSession();
      $form = $this->createForm(DemandeEmbaucheType::class, $session->get('demande'), array('step' => '3'));

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        // $em = $this->getDoctrine()->getManager();

        $demandeService->createDemande($form->getData(), $request->getSession()->get('idSalon'));

        // $demande = new DemandeComplexe();
        // $demande->setService('juridique');
        // $demande->setUser($this->getUser());
        // $demande->setIdSalon($idSalon = $request->getSession()->get('idSalon'));
        //
        // $demandeEmbauche = $form->getData();//$request->getSession()->get('demande');
        //
        // $fileName = $fileUploader->upload($demandeEmbauche->getCarteId());
        // $demandeEmbauche->setCarteId($fileName);
        //
        // $fileName = $fileUploader->upload($demandeEmbauche->getCarteVitale());
        // $demandeEmbauche->setCarteVitale($fileName);
        //
        // $fileName = $fileUploader->upload($demandeEmbauche->getRib());
        // $demandeEmbauche->setRib($fileName);
        //
        // $fileName = $fileUploader->upload($demandeEmbauche->getDiplomeFile());
        // $demandeEmbauche->setDiplomeFile($fileName);
        //
        // $fileName = $fileUploader->upload($demandeEmbauche->getMutuelle());
        // $demandeEmbauche->setMutuelle($fileName);
        //
        // $demandeEmbauche->setTypeForm("Demande d'embauche");
        // $demande->setDemandeform($demandeEmbauche);
        //
        // // Notification par Mail
        // // $destinataire = $em->getRepository('AppBundle:User')->findOneBy(array('idPersonnel' => $personnel->getId()));
        // // $destinataire = $destinataire->getEmail();
        //
        // $user = $this->getUser();
        // $emetteur = $user->getEmail();
        //
        // $message = (new \Swift_Message('Nouvelle demande d\'embauche '))
        //    ->setFrom('send@example.com')
        //    ->setTo('recipient@example.com')
        //    ->setBody(
        //        $this->renderView(
        //            'emails/demande_acompte.html.twig',
        //            array('personnel' => $demandeEmbauche->getPrenom(). ' '.$demandeEmbauche->getNom(),
        //                   'user' => $user->getUsername(),
        //                   'demande' => 'd\'embauche'
        //                 )
        //        ),
        //        'text/html'
        //    );
        // $mailer->send($message);
        //
        // $em->persist($demande);
        // $em->flush();
        // $this->addFlash("success", "La demande d'embauche pour ".$demandeEmbauche->getPrenom()." ".$demandeEmbauche->getNom()."a correctement été envoyé ! Un mail vous sera envoyé une fois votre demande traité.");

        return $this->redirect($this->generateUrl('homepage',
      array('flash' => "La demande d'acompte a correctement été envoyée !
      Un mail vous sera envoyé une fois votre demande traitée.")));
        }

      return $this->render('embauche3.html.twig', array(
        'img'   => $request->getSession()->get('img'),
        'form'  => $form->createView()
        )
      );
    }


}
