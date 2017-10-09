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
use AppBundle\Form\DemandeEmbaucheType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class DemandeDetailController extends Controller
{
  /**
   * @Route("/demande/{id}", name="demande_detail", requirements={"id": "\d+"})
   */
  public function detailIdAction(Request $request, $id)
  {
    $demande = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:DemandeEntity')
                    ->findOneBy(array("id" => $id));

    if ($demande instanceof DemandeSimple)
      return self::detailSimple($demande, $request);
    return self::detailComplexe($demande, $request);
  }

  public function detailSimple($demande, $request)
  {
    $em = $this->getDoctrine()->getManager("referentiel");

    $salon = $em->getRepository('ApiBundle:Salon')
                ->findOneBy(array('sage' => $demande->getidSalon()));

    $demandeur = $em->getRepository('ApiBundle:Personnel')
                    ->findOneBy(array('matricule' => $demande->getUser()->getIdPersonnel()));

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

    if ($form2->isSubmitted()) {
      if ($form2->get('reject')->isClicked())
      {

            if($form2["message"]->getData() == null){

              $this->addFlash("error", "Il est obligatoire de saisir un motif pour votre rejet de demande d'acompte");
              return $this->redirect($this->generateUrl('demande_detail', array('id' => $id)));
              die();

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

    if ($demande->getDemandeform()->getTypeForm() == "Demande d'acompte")
    {
      $demandeacompte = new DemandeAcompte();
      $demandeacompte = $demande->getDemandeform();
      $form = $this->createForm(DemandeAcompteType::class,
                                $demandeacompte,
                                array("idSalon" => null,
                                      "idPersonnel" => $demande->getDemandeform()->getIdPersonnel()
                                    ));
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


    if($dateTraitement)
      $dateTraitement = $dateTraitement->format('d-m-Y H:i');
    return $this->render('demande_detail.html.twig', array(
      'demandeur'       => $demandeur,
      'date'            => $date->format('d-m-Y H:i'),
      'dateTraitement'  => $dateTraitement,
      'statut'          => $statut,
      'message'         => $message,
      'typedemande'     => $typedemande,
      'salon'           => $salon,
      'form'            => $form->createView(),
      'form2'           => $form2->createView(),
    ));
  }

  public function demandeComplexe($demande, $request)
  {

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
