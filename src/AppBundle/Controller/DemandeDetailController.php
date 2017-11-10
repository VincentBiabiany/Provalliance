<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\DemandeEntity;
use AppBundle\Entity\DemandeComplexe;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Form\DemandeAcompteType;
use AppBundle\Form\DemandeComplexeType;
use AppBundle\Form\DemandeEmbaucheType;
use ApiBundle\Entity\Personnel;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\Service\FileUploader;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Service\ResumeDemandeService;

class DemandeDetailController extends Controller
{
    /**
    * @Route("/demande/{id}", name="demande_detail", requirements={"id": "\d+"})
    */
    public function detailIdAction(Request $request, $id, FileUploader $fileuploader, ResumeDemandeService $ResumeDemandeService)
    {
      $demande = $this->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:DemandeEntity')
      ->findOneBy(array("id" => $id));

      if ($demande instanceof DemandeSimple)
        return self::detailSimple($demande, $request, $id, $ResumeDemandeService);
      return self::detailComplexe($demande, $request, $id, $fileuploader);
    }

    public function detailSimple($demande, $request, $id, $ResumeDemandeService)
    {
      $em = $this->getDoctrine()->getManager("referentiel");
      $salon = $em->getRepository('ApiBundle:Salon')
                  ->findOneBy(array('sage' => $demande->getidSalon()));

      $demandeur = $em->getRepository('ApiBundle:Personnel')
                      ->findOneBy(array('matricule' => $demande->getUser()->getMatricule()));
      if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true) || $demandeur == null)
      {
        $demandeur = new Personnel();
        $demandeur->setNom('Admin');
        $demandeur->setPrenom('');
      }

      $statut = $demande->getstatut();
      $typedemande = $demande->getDemandeform()->getTypeForm();
      $date = $demande->getDateEnvoi();
      $dateTraitement = $demande->getDateTraitement();
      $message = $demande->getMessage();

      $form2 = $this->createFormBuilder()
                    ->setMethod("POST")
                    ->add('message', TextareaType::class, array(
                      'attr' => ['class' => 'form-control col-sm-9 col-xs-12'],
                      'label_attr' => ['class' => 'control-label label col-sm-3 col-xs-12'],
                      'label' => 'Motif',
                      'data' => $message))
                    ->add('accept', SubmitType::class)
                    ->add('reject', SubmitType::class)
                    ->getForm();

        $form2->handleRequest($request);
        if ($form2->isSubmitted())
        {
          if ($form2->get('reject')->isClicked())
          {
            if($form2["message"]->getData() == null)
            {
              $this->addFlash("error", "Il est obligatoire de saisir un motif pour votre rejet de demande d'acompte");
              return $this->redirect($this->generateUrl('demande_detail', array('id' => $id)));
            }
            $demande->setstatut(DemandeEntity::statut_REJETE);
            $demande->setDateTraitement(new \DateTime());
            $demande->setMessage($form2["message"]->getData());
          }
          else
          {
            $demande->setstatut(DemandeEntity::statut_TRAITE);
            $demande->setDateTraitement(new \DateTime());
            $demande->setMessage($form2["message"]->getData());
          }
          $this->getDoctrine()->getManager()->flush();
          $this->addFlash("success", "Demande correctement traitée");
          return $this->redirectToRoute("demande");
        }

    //     if ($demande->getDemandeform()->getTypeForm() == "Demande d'acompte")
    //     {
    //       $demandeacompte = new DemandeAcompte();
    //       $demandeacompte = $demande->getDemandeform();
    //       $form = $this->createForm(DemandeAcompteType::class,
    //       $demandeacompte,
    //       array("idSalon" => null,
    //       "matricule" => $demande->getDemandeform()->getMatricule()
    //     ));
    //   }



    if($dateTraitement)
      $dateTraitement = $dateTraitement->format('d-m-Y H:i');
    return $this->render('demande_detail.html.twig', array(
      'idDemande'       => $request->get('id'),
      'date'            => $date->format('d-m-Y H:i'),
      'dateTraitement'  => $dateTraitement,
      'statut'          => $statut,
      'message'         => $message,
      'typedemande'     => $typedemande,
      'salon'           => $salon,
      'form2'           => $form2->createView(),
      'img'             => $request->getSession()->get('img'),
    ));
  }
  /**
   * @Route("/generateResume", name="generateResume")
   */
  public function generateResume(Request $request, ResumeDemandeService $ResumeDemandeService)
  {
    // On récupère le service
    $idDemande[0] = $request->get('id');
    $response = $ResumeDemandeService->generateResume($idDemande);
    return new Response(json_encode($response), 200, ['Content-Type' => 'application/json']);

  }


  public function detailComplexe($demande, $request, $id, $fileuploader)
  {
    $em = $this->getDoctrine()->getManager("referentiel");

    $salon = $em->getRepository('ApiBundle:Salon')
                ->findOneBy(array('sage' => $demande->getidSalon()));
    $demandeur = $em->getRepository('ApiBundle:Personnel')
                    ->findOneBy(array('matricule' => $demande->getUser()->getMatricule()));
    if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true) || $demandeur == null)
    {
      $demandeur = new Personnel();
      $demandeur->setNom('Admin');
      $demandeur->setPrenom('');
    }

    $statut = $demande->getstatut();
    $typedemande = $demande->getDemandeform()->getTypeForm();
    $date = $demande->getDateEnvoi();
    $dateTraitement = $demande->getDateTraitement();

    $docSalon = $demande->getDocSalon();
    $docService = $demande->getDocService();

    // Construction du formulaire
    $form2 = $this->createForm(DemandeComplexeType::class, $demande, array("demande" => $demande));

    // Traitement de l'ajout de doc
    $form2->handleRequest($request);
    if ($form2->isSubmitted())
    {
      if ( $form2->has('reject') && $form2->get('reject')->isClicked())
      {
        dump('reject');
        if ($form2->has('message') && $form2["message"]->getData() == null)
        {
          $this->addFlash("error", "Il est obligatoire de saisir un motif pour votre rejet de demande d'acompte");
          return $this->redirect($this->generateUrl('demande_detail', array('id' => $id)));
        }

        $demande->setstatut(DemandeEntity::statut_REJETE);
        $demande->setDateTraitement(new \DateTime());

        if ($form2->has('message'))
          $demande->setMessage($form2["message"]->getData());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("demande");
      }

      self::traitement($form2, $demande, $id, $fileuploader);
      return $this->redirectToRoute("demande");
    }

    if ($demande->getDemandeform()->getTypeForm() == "Demande d'embauche")
    {
      $demandeEmbauche = new DemandeEmbauche();
      $demandeEmbauche = $demande->getDemandeform();
      $form = $this->createForm(DemandeEmbaucheType::class,
                                          $demandeEmbauche,
                                          array("step" => 4,
                                        ));
    }

    if ($dateTraitement)
      $dateTraitement = $dateTraitement->format('d-m-Y H:i');

    return $this->render('demande_detail_complexe.html.twig', array(
      'demandeur'       => $demandeur,
      'date'            => $date->format('d-m-Y H:i'),
      'dateTraitement'  => $dateTraitement,
      'statut'          => $statut,
      'typedemande'     => $typedemande,
      'salon'           => $salon,
      'form'            => $form->createView(),
      'form2'           => $form2->createView(),
      'docSalon'        => $docSalon,
      'docService'      => $docService,
      'img'             => $request->getSession()->get('img'),

    ));
  }

  public function traitement($form2, $demande, $id, $fileUploader)
  {
  //  $fileUploader = $this->get(FileUploader::class);

    if ($demande->getStatut() == DemandeEntity::statut_AVALIDE)
    {
      $demande->setstatut(DemandeEntity::statut_TRAITE);
      $demande->setDateTraitement(new \DateTime());

      if ($form2->has('message'))
        $demande->setMessage($form2["message"]->getData());

      if ($form2->has('docSalon') && $form2["docSalon"]->getData() != null)
      {
        $fileName = $fileUploader->upload($form2["docSalon"]->getData());
        $demande->setDocSalon($fileName);
      }
    }
    if ($demande->getStatut() == DemandeEntity::statut_ASIGNE)
    {
      $demande->setstatut(DemandeEntity::statut_AVALIDE);
      $demande->setDateTraitement(new \DateTime());

      if ($form2->has('message'))
        $demande->setMessage($form2["message"]->getData());

      if ($form2->has('docSalon') && $form2["docSalon"]->getData() != null)
      {
        $fileName = $fileUploader->upload($form2["docSalon"]->getData());
        $demande->setDocSalon($fileName);
      }
    }

    if ($demande->getStatut() == DemandeEntity::statut_EN_COURS)
    {
      $demande->setstatut(DemandeEntity::statut_ASIGNE);
      $demande->setDateTraitement(new \DateTime());

      if ($form2->has('message'))
        $demande->setMessage($form2["message"]->getData());

      if ($form2["docService"]->getData() != null)
      {
        $fileName = $fileUploader->upload($form2["docService"]->getData());
        $demande->setDocService($fileName);
      }
    }

    $this->getDoctrine()->getManager()->flush();
    $this->addFlash("success", "Demande correctement traitée");

  }

  /**
  * @Route("/detail", name="detail")
  */
  public function detailAction(Request $request)
  {
    return new Response($this->generateUrl('demande_detail',
          array('id' => $request->get('id')
        )));
  }
}
