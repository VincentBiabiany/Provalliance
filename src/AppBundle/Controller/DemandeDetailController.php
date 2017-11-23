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
use AppBundle\Entity\DemandeEssaiProfessionnel;
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
        return self::detailSimple($demande, $request, $id, $fileuploader, $ResumeDemandeService);
      return self::detailComplexe($demande, $request, $id, $fileuploader, $ResumeDemandeService);
    }

    public function detailSimple($demande, $request, $id, $fileuploader, $ResumeDemandeService)
    {
      $em = $this->getDoctrine()->getManager("referentiel");
      $salon = $em->getRepository('ApiBundle:Salon')
                  ->findOneBy(array('sage' => $demande->getidSalon()));

      $demandeur = $em->getRepository('ApiBundle:Personnel')
                      ->findOneBy(array('matricule' => $demande->getUser()->getMatricule()));
      if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true) || $demandeur == null) {
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
                    ->setMethod("POST");

      if ($statut != 0 && $statut != 2){
          $form2 = $form2->add('message', TextareaType::class, array(
                                'attr' => ['class' => 'form-control col-sm-9 col-xs-12'],
                                'label_attr' => ['class' => 'control-label label col-sm-3 col-xs-12'],
                                'label' => 'Motif',
                                'data' => $message))
                        ->add('docService', FileType::class, ['label' => 'Ajouter un document'])
                        ->add('reject', SubmitType::class, array( 'attr' => ['class'=>'btn-black end reject']))
                        ->add('accept', SubmitType::class, array( 'attr' => ['class'=>'btn-black end accept']));
        }

        $form2 = $form2->getForm();
        $form2->handleRequest($request);

        if ($form2->isSubmitted()) {
          if ($form2->get('reject')->isClicked()) {

            if($form2["message"]->getData() == null) {
              $this->addFlash("error", "Il est obligatoire de saisir un motif pour votre rejet de demande d'acompte");
              return $this->redirect($this->generateUrl('demande_detail', array('id' => $id)));
            }

            $demande->setstatut(DemandeEntity::statut_REJETE);
            $demande->setDateTraitement(new \DateTime());
            $demande->setMessage($form2["message"]->getData());

          } else {

            $demande->setstatut(DemandeEntity::statut_TRAITE);
            $demande->setDateTraitement(new \DateTime());

            if ($form2["docService"]->getData() != null) {

              $fileName = $fileuploader->upload($form2["docService"]->getData(), $demande->getDemandeform()->getMatricule(), $demande->getDemandeform()->getNomDoc(), 'pj-service');
              $demande->setDocService($fileName);
            }
            $demande->setMessage($form2["message"]->getData());
          }
          $this->getDoctrine()->getManager()->flush();
          $this->addFlash("success", "Demande correctement traitée");
          return $this->redirectToRoute("demande");
        }

    if($dateTraitement)
      $dateTraitement = $dateTraitement->format('d/m/Y');

      $detail = self::generateResume($request->get('id'), $ResumeDemandeService);
    return $this->render('demande_detail.html.twig', array(
      'idDemande'       => $request->get('id'),
      'demandeur'       => $demandeur,
      'date'            => $date->format('d/m/Y'),
      'dateTraitement'  => $dateTraitement,
      'statut'          => $statut,
      'message'         => $message,
      'typedemande'     => $typedemande,
      'salon'           => $salon,
      'form2'           => $form2->createView(),
      'img'             => $request->getSession()->get('img'),
      'detail'          => $detail
    ));
  }

  /**
   * @Route("/generateResume", name="generateResume")
   */
  public function generateResume($idDemande, $ResumeDemandeService)
  {
    // On récupère le service
    //$idDemande[0] = $request->get('id');
    $response = $ResumeDemandeService->generateResume([$idDemande], 'detail');
    return $response;//new Response(json_encode($response), 200, ['Content-Type' => 'application/json']);

  }


  public function detailComplexe($demande, $request, $id, $fileuploader, $ResumeDemandeService)
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
    if ($form2->isSubmitted()) {

      if ( $form2->has('reject') && $form2->get('reject')->isClicked()) {

        if ($form2->has('message') && $form2["message"]->getData() == null) {
          $this->addFlash("error", "Il est obligatoire de saisir un motif pour votre rejet");
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

    if ($dateTraitement)
      $dateTraitement = $dateTraitement->format('d/m/Y');

      $detail = self::generateResume($request->get('id'), $ResumeDemandeService);
    return $this->render('demande_detail_complexe.html.twig', array(
      'idDemande'       => $request->get('id'),
      'demandeur'       => $demandeur,
      'date'            => $date->format('d/m/Y'),
      'dateTraitement'  => $dateTraitement,
      'statut'          => $statut,
      'typedemande'     => $typedemande,
      'salon'           => $salon,
      'form2'           => $form2->createView(),
      'docSalon'        => $docSalon,
      'docService'      => $docService,
      'img'             => $request->getSession()->get('img'),
      'detail'          => $detail
    ));
  }

  public function traitement($form2, $demande, $id, $fileUploader)
  {
    if ($demande->getDemandeform() instanceof DemandeEssaiProfessionnel || $demande->getDemandeform() instanceof DemandeEmbauche)
      $matricule = 0;
    else if ($demande->getDemandeform() instanceof AutreDemande) {

      if ($demande->getDemandeform()->getMatricule() != null)
        $matricule = $demande->getDemandeform()->getMatricule();
      else
        $matricule = 0;
    } else {
      $matricule = $demande->getDemandeform()->getMatricule();
    }

    $nomDoc = $demande->getDemandeform()->getNomDoc();

    if ($demande->getStatut() == DemandeEntity::statut_AVALIDE) {
      $demande->setstatut(DemandeEntity::statut_TRAITE);
      $demande->setDateTraitement(new \DateTime());

      if ($form2->has('message'))
        $demande->setMessage($form2["message"]->getData());

      if ($form2->has('docSalon') && $form2["docSalon"]->getData() != null) {

        $fileName = $fileUploader->upload($form2["docSalon"]->getData(), $matricule, $nomDoc, 'pj-salon');
        $demande->setDocSalon($fileName);
      }

    }

    if ($demande->getStatut() == DemandeEntity::statut_ASIGNE) {
      $demande->setstatut(DemandeEntity::statut_AVALIDE);
      $demande->setDateTraitement(new \DateTime());

      if ($form2->has('message'))
        $demande->setMessage($form2["message"]->getData());

      if ($form2->has('docSalon') && $form2["docSalon"]->getData() != null) {

        $fileName = $fileUploader->upload($form2["docSalon"]->getData(), $matricule, $nomDoc, 'pj-service');
        $demande->setDocSalon($fileName);
      }
    }

    if ($demande->getStatut() == DemandeEntity::statut_EN_COURS) {
      $demande->setstatut(DemandeEntity::statut_ASIGNE);
      $demande->setDateTraitement(new \DateTime());

      if ($form2->has('message'))
        $demande->setMessage($form2["message"]->getData());

      if ($form2["docService"]->getData() != null) {
        $fileName = $fileUploader->upload($form2["docService"]->getData(), $matricule, $nomDoc, 'pj-service');
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
