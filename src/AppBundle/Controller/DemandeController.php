<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\DemandeEntity;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Form\DemandeAcompteType;
use AppBundle\Form\DemandeEmbaucheType;
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


    public function wichService($typeFilter,$column,$dir,$idsalon,$search,$start,$length){

      //Requete en bdd en fonction du type de filre
      if (($typeFilter == 'x') or ($typeFilter == 'init') or ($typeFilter == 'search')) {
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:Demande');

        if (in_array('ROLE_PAIE', $this->getUser()->getRoles(), true)) {
          $query = $repository->createQueryBuilder('p')
          ->where('p.service = :serviceUser')
          ->setParameter('serviceUser', 'paie')
          ->orderBy('p.dateTraitement', 'DESC')
          ->setFirstResult( $start )
          ->setMaxResults( $length )
          ->getQuery();

        } else if (in_array('ROLE_JURIDIQUE', $this->getUser()->getRoles(), true)){
          $query = $repository->createQueryBuilder('p')
          ->where('p.service = :serviceUser')
          ->setParameter('serviceUser', 'juridique')
          ->orderBy('p.dateTraitement', 'DESC')
          ->setFirstResult( $start )
          ->setMaxResults( $length )
          ->getQuery();
        } else {

          $query = $repository->createQueryBuilder('p')
          ->where('p.idSalon = :salon')
          ->setParameter('salon', $idsalon)
          ->orderBy('p.dateTraitement', 'DESC')
          ->setFirstResult( $start )
          ->setMaxResults( $length )
          ->getQuery();
        }

        $demandes = $query->getResult();

        //Affichage via filtre "normaux"
      }else if($typeFilter == 'default'){
        if (in_array('ROLE_PAIE', $this->getUser()->getRoles(), true)) {
          $demandes = $this->getDoctrine()
          ->getManager()->getRepository('AppBundle:Demande')
          ->findBy(array("service" => "paie"),
          array($column => $dir),
          $length, $start);

        } else if (in_array('ROLE_JURIDIQUE', $this->getUser()->getRoles(), true)){
          $demandes = $this->getDoctrine()
          ->getManager()->getRepository('AppBundle:Demande')
          ->findBy(array("service" => "juridique"),
          array($column => $dir),
          $length, $start);
        } else {
          $demandes = $this->getDoctrine()
          ->getManager()->getRepository('AppBundle:Demande')
          ->findBy(array("idSalon" => $idsalon),
          array($column => $dir),
          $length, $start);
        }
      }
      return $demandes;
    }


    public function displayDemandes($typeFilter,$column,$dir,$idsalon,$search,$start,$length){
        //Requete dans la bdd en fonction de la colonne et de la direction récupérée
        $demandes = self::wichService($typeFilter,$column,$dir,$idsalon,$search,$start,$length);

          $entitym = $this->getDoctrine()->getManager();
          $demandeRepo = $entitym->getRepository('AppBundle:DemandeEntity');
          $role= $this->getUser()->getRoles();
          $role= $role[0];

          $nb = $demandeRepo->getNb($role,$idsalon);
          $output = array(
               'data' => array(),
               'recordsFiltered' => $nb[0][1],
               'recordsTotal' => $nb[0][1]
          );

      $em = $this->getDoctrine()->getManager("referentiel");
      foreach ($demandes as $demande ) {
        $demandeur = $em->getRepository('ApiBundle:Personnel')
                        ->findOneBy(array('matricule' => $demande->getUser()->getIdPersonnel()));

 		if ($demande->getDemandeform()->getTypeForm() == "Demande d'acompte"){
			$collab = $em->getRepository('ApiBundle:Personnel')
					->findOneBy(array('matricule' => $demande->getDemandeform()->getIdPersonnel()));
			$collab = $collab->getNom() . " " . $collab->getPrenom();
		}else{
			$collab = $demande->getDemandeform()->getNom() . " " . $demande->getDemandeform()->getPrenom();
		}
        $date = $demande->getDateTraitement();
        if($demande->getstatut() == 0){
            $statut="Rejeté";

        }else if ($demande->getstatut() == 1){
            $statut="En cours";

        }else if ($demande->getstatut() == 2){
            $statut="Traité";

        }
        $output['data'][] = [
          'id'               => $demande->getId(),
          ''                 => '<span class="glyphicon glyphicon-search click"></span>',
          'Salon'            => $em->getRepository('ApiBundle:Salon')->findOneBy(array("sage" => $demande->getidSalon()))->getAppelation(),
          'Demandeur'        => $demandeur->getNom() . " " . $demandeur->getPrenom(),
          'dateEnvoi'        => $date->format('d-m-Y H:i'),
          'statut'           => $statut,
          'Type de demande'  => $demande->getDemandeform()->getTypeForm(),
          'Collaborateur'    => $collab,
          'Marque'           => ""
        ];
      }


      if ($typeFilter == 'x'){

          if($dir == "asc"){ $direction = SORT_ASC;}else { $direction = SORT_DESC; }

              foreach ($output['data'] as $key => $row) {
              	$col[$key]  = $row[$column];
              }
              array_multisort($col, $direction, $output['data']);
              return $output;
         }else{
             return $output;
      }
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
          $start = $request->get('start');
        //$search = $request->get('search');


          $idsalon = $request->getSession()->get('idSalon');

    //Affichage par défault sans filtre actif
    if ( !$request->get('order')){

            $typeFilter = 'init';

     return new Response(json_encode(self::displayDemandes($typeFilter,null,null,$idsalon,null,$start,$length)), 200, ['Content-Type' => 'application/json']);

    //Affichage lors d'un tri
    }else if ($request->get('order')){
      //On récupère la colonne filtrée et la direction du tri
      $order = $request->get('order');
      $tri = $order[0]['column'];
      $dir = $order[0]['dir'];
      $columns = $request->get('columns');
      $column = $columns[$tri]['data'];
      $typeFilter = $columns[$tri]['name'];
      $idsalon = $request->getSession()->get('idSalon');

      return new Response(json_encode(self::displayDemandes($typeFilter,$column,$dir,$idsalon,null,$start,$length)), 200, ['Content-Type' => 'application/json']);


      }
}



}
