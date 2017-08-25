<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    foreach ( $demandes as $demande ) {
      $demandeur = $em->getRepository('ApiBundle:Personnel')->findOneBy(array('id' => $demande->getUser()->getIdPersonnel()));
      $collab = $em->getRepository('ApiBundle:Personnel')->findOneBy(array('id' => $demande->getDemandeform()->getIdPersonnel()));
      $date = $demande->getDateEnvoi();
      $output['data'][] = [
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

}
