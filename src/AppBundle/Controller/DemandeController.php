<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\Demande;
use AppBundle\Form\DemandeAcompteType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DemandeController extends Controller
{
    /**
     * @Route("/demande", name="demande")
     */
    public function indexAction(Request $request)
    {
      return $this->render('demande.html.twig', array(
        'img' => $request->getSession()->get('img')
      ));
    }

  /**
   * @Route("/paginate", name="paginate")
   */
  public function paginateAction(Request $request)
  {
    if(!$request->isMethod('post'))
      return $this->render('demande.html.twig', array(
        'img' => $request->getSession()->get('img')
      ));

    $length = $request->get('length');
    $length = $length && ($length != -1 ) ? $length : 0;

    $start = $request->get('start');
    $start = $length ? ($start && ($start !=-1 ) ? $start :0 ) / $length : 0;

    $search = $request->get('search');
    $filters = [
        'query' => @$search['value']
    ];

    if (in_array('ROLE_PAIE', $this->getUser()->getRoles(), true)) {
      $demandes = $this->getDoctrine()
                       ->getManager()->getRepository('AppBundle:Demande')
                       ->findBy(array("service" => "paie"));

    } else if (in_array('ROLE_JURIDIQUE', $this->getUser()->getRoles(), true)){
      $demandes = $this->getDoctrine()
                       ->getManager()->getRepository('AppBundle:Demande')
                       ->findBy(array("service" => "juridique"));
    } else {
      $demandes = $this->getDoctrine()
                       ->getManager()->getRepository('AppBundle:Demande')
                       ->findBy(array("idSalon" => $request->getSession()->get('idSalon')));
    }

    $output = array(
         'data' => array(),
         'recordsFiltered' => count($demandes),
         'recordsTotal' => count($demandes)
    );

    $em = $this->getDoctrine()->getManager("referentiel");

    foreach ($demandes as $demande) {
      $demandeur = $em->getRepository('ApiBundle:Personnel')
                      ->findOneBy(array('id' => $demande->getUser()->getIdPersonnel()));

      $collab = $em->getRepository('ApiBundle:Personnel')
                   ->findOneBy(array('id' => $demande->getDemandeform()->getIdPersonnel()));
      $date = $demande->getDateTraitement();
      $output['data'][] = [
        'id'               => $demande->getId(),
        ''                 => '<span class="glyphicon glyphicon-search click"></span>',
        'Salon'            => $em->getRepository('ApiBundle:Salon')->findOneBy(array("id" => $demande->getidSalon()))->getNom(),
        'Demandeur'        => $demandeur->getNom() . " " . $demandeur->getPrenom(),
        'Date'             => $date->format('d-m-Y H:i'),
        'Statut'           => $demande->getStatus(),
        'Type de demande'  => $demande->getDemandeform()->getTypeForm(),
        'Collaborateur'    => $collab->getNom() . " " . $collab->getPrenom()
      ];
    }
    return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
  }

  /**
   * @Route("/demande/{id}", name="demande_detail", requirements={"id": "\d+"})
   */
  public function detailIdAction(Request $request, $id)
  {
    $demande = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Demande')
                    ->findOneBy(array("id" => $id));

    $em = $this->getDoctrine()->getManager("referentiel");

    $salon = $em->getRepository('ApiBundle:Salon')
                ->findOneBy(array('id' => $demande->getidSalon()));

    $demandeur = $em->getRepository('ApiBundle:Personnel')
                    ->findOneBy(array('id' => $demande->getUser()->getIdPersonnel()));

    $status = $demande->getStatus();
    $typedemande = $demande->getDemandeform()->getTypeForm();
    $date = $demande->getDateEnvoi();
    $dateTraitement = $demande->getDateTraitement();
    $message = $demande->getMessage();


    $form2 = $this->createFormBuilder()
                      ->setMethod("POST")
                      ->add('message', TextareaType::class, array( 'label' => 'Motif','data' => $message))
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
        $demande->setStatus(Demande::STATUS_REJETE);
        $demande->setDateTraitement(new \DateTime());
        $demande->setMessage($form2["message"]->getData());

      }
      else
      {
        $demande->setStatus(Demande::STATUS_TRAITE);
        $demande->setDateTraitement(new \DateTime());
        $demande->setMessage($form2["message"]->getData());
      }
      $this->getDoctrine()->getManager()->flush();
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
    if($dateTraitement)
      $dateTraitement = $dateTraitement->format('d-m-Y H:i');
    return $this->render('demande_detail.html.twig', array(
      'demandeur'       => $demandeur,
      'date'            => $date->format('d-m-Y H:i'),
      'dateTraitement'  => $dateTraitement,
      'status'          => $status,
      'message'         => $message,
      'typedemande'     => $typedemande,
      'salon'           => $salon,
      'form'            => $form->createView(),
      'form2'           => $form2->createView(),
    ));
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
