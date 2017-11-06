<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\DemandeEntity;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Entity\DemandeComplexe;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Form\DemandeAcompteType;
use AppBundle\Form\DemandeEmbaucheType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
        $form = $this->createFormBuilder()
                     ->add('idDemandes', HiddenType::class)
                     ->getForm();

              return $this->render('demande.html.twig', array(
                'img' => $request->getSession()->get('img'),
                'flash'=> null,
                'form' => $form->createView()
              ));

    }
    /**
     * @Route("/demande/{origin}/{nb}", name="demandeShow")
     */
    public function showAction(Request $request)
    {

        $form = $this->createFormBuilder()
                     ->add('idDemandes', HiddenType::class)
                     ->getForm();

            if($request->get('nb') == '1'){
                $flash= $request->get('nb').' demande validée';
            }else{
                $flash= $request->get('nb').' demandes validées';
            }

            return $this->render('demande.html.twig', array(
              'img' => $request->getSession()->get('img'),
              'flash'=> $flash,
              'form' => $form->createView()
            ));

    }
    /**
    * @Route("/filter", name="filter")
    */
    public function filterAction(Request $request)
    {
      $isService = true;
      // Filtre des demandes pour manager/coordo
      if (in_array('ROLE_MANAGER', $this->getUser()->getRoles(), true)
       || in_array('ROLE_COORD', $this->getUser()->getRoles(), true)
       || in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true)) {
         $isService = false;
         $idSalon = $request->getSession()->get('idSalon');
      }

      if (in_array('ROLE_PAIE', $this->getUser()->getRoles(), true))
        $service = 'paie';
      else
        $service ='juridique';


        $col = array(
          "id",
          "",
          "sage",
          "enseigne",
          "appelation",
          "coordinateur",
          "demandeur",
          "dateTraitement",
          "statut",
          "type",
          "collaborateur",
        );

        $nb = $request->get('selected');
        $em = $this->getDoctrine()->getManager();

        if ($col[$nb] == "sage"  || $col[$nb] == "appelation") {

          $em = $this->getDoctrine()->getManager('referentiel');
          $query = $em->createQueryBuilder('u')
                      ->select('u.'.$col[$nb])
                      ->distinct()
                      ->from('ApiBundle:Salon', 'u')
                      ->orderBy("u." . $col[$nb], "ASC");
          if (!$isService)
            $query = $query->where('u.sage = :salon')->setParameter('salon', $idSalon);
          $query =  $query->getQuery();

        } else if ($col[$nb] == "enseigne") {

          $em = $this->getDoctrine()->getManager('referentiel');
          $query = $em->createQueryBuilder('u')
                      ->select('e.nom as enseigne')
                      ->distinct()
                      ->from('ApiBundle:Salon', 'u')
                      ->leftjoin('u.enseigne', 'e');
          if (!$isService)
            $query = $query->where('u.sage = :salon')->setParameter('salon', $idSalon);
          $query =  $query->getQuery();

        }  else if ($col[$nb] == "coordinateur" ) {

          $em = $this->getDoctrine()->getManager('referentiel');

          $query = $em->createQueryBuilder('u')
                      ->select("CONCAT(e.prenom , ' ' , e.nom) as ".$col[$nb])
                      ->distinct()
                      ->from('ApiBundle:PersonnelHasSalon', 'u')
                      ->leftjoin('u.personnelMatricule', 'e')
                      ->where('u.profession = 2');
          if (!$isService)
            $query = $query->andWhere('u.salonSage = :salon')->setParameter('salon', $idSalon);
          $query =  $query->getQuery();

        }  else if ($col[$nb] == "demandeur") {

          $query1 = $em->createQueryBuilder('u')
                      ->select("e.idPersonnel")
                      ->distinct()
                      ->from('AppBundle:DemandeEntity', 'u')
                      ->leftjoin('u.user', 'e');
          if (!$isService)
            $query1 = $query1->where('u.idSalon = :salon')->setParameter('salon', $idSalon);
          $query1 =  $query1->getQuery()->getResult();

          foreach ($query1 as $key => $value) {
            $array[] = $value['idPersonnel'];
          }

          $em = $this->getDoctrine()->getManager('referentiel');
          $query = $em->createQueryBuilder('p')
                      ->select("CONCAT(p.prenom , ' ' , p.nom) as ".$col[$nb])
                      ->distinct()
                      ->from('ApiBundle:Personnel', 'p')
                      ->where('p.matricule IN (:id)')
                      ->setParameter('id',  $array)
                      ->getQuery();

        } else if ($col[$nb] == "type") {

            $query = $em->createQueryBuilder('u')
                        ->select("e.typeForm as ".$col[$nb])
                        ->distinct()
                        ->from('AppBundle:DemandeEntity', 'u')
                        ->leftjoin('u.demandeform', 'e');
            if (!$isService)
              $query = $query->where('u.idSalon = :salon')->setParameter('salon', $idSalon);
            else {
              if (in_array('ROLE_PAIE', $this->getUser()->getRoles(), true))
                $query = $query->where('u.service = :service')->setParameter('service', 'paie');
              else
                $query = $query->where('u.service = :service')->setParameter('service', 'juridique');
            }
            $query =  $query->getQuery();

          } else if ($col[$nb] == "collaborateur") {

            $persoRepo = $this->getDoctrine()->getManager('referentiel')->getRepository('ApiBundle:Personnel');
            $demandeRepo = $em->getRepository('AppBundle:DemandeEntity');

            // Récup des demande du Salon
            if (!$isService)
             $demandesSalon = $demandeRepo->findBy(array("idSalon" => $idSalon));
            else
             $demandesSalon = $demandeRepo->findBy(array("service" => $service));

            // Récup par demande du collab
            foreach ($demandesSalon as $key => $demande) {

              if ($demande->getDemandeform()->getTypeForm() == "Demande d'embauche") {
                $collab[] = $demandeRepo->whichPersonnel($demande);
              } else {
                $idP = $demande->getDemandeform()->getIdPersonnel();
                $collab[] =  $persoRepo->whichPersonnel($demande,$idP);
              }
            }

            $collab = array_unique($collab);
            foreach ($collab as $key => $value) {
              $array[] = ["collaborateur" => $value];
            }

        } else {
          $query = $em->createQueryBuilder('u')
                      ->select('u.'.$col[$nb])
                      ->distinct()
                      ->from('AppBundle:DemandeEntity', 'u')
                      ->orderBy("u." . $col[$nb], "ASC");
          if (!$isService)
            $query = $query->where('u.idSalon = :salon')->setParameter('salon', $idSalon);
          $query =  $query->getQuery();
        }

        if (isset($query))
          $array = $query->getArrayResult();

        //dump($array);
        $row = array();

        if ($array){
          foreach ($array as $key => $value) {

            if ($col[$nb] == "dateTraitement") {
              $row[] = $value[$col[$nb]]->format('d-m-Y H:i:s');

            } else if ($col[$nb] == "statut"){
              $row[] = $this->getDoctrine()->getManager()->getRepository("AppBundle:DemandeEntity")
              ->whichStatut($value[$col[$nb]]);

            } else {
              if ($value[$col[$nb]] != null)
                $row[] = $value[$col[$nb]];
            }

          }
        }
        return new Response(json_encode($row), 200, ['Content-Type' => 'application/json']);
    }

    public function displayDemandes($typeFilter,$column,$dir,$idsalon,$search,$start,$length){
      $entitym = $this->getDoctrine()->getManager();
      $demandeRepo = $entitym->getRepository('AppBundle:DemandeEntity');

      $em = $this->getDoctrine()->getManager('referentiel');
      $persoRepo = $em->getRepository('ApiBundle:Personnel');

      $role = $this->getUser()->getRoles();
      $role = $role[0];

      if (is_array($typeFilter))
        $demandes = $demandeRepo->filterDemande($typeFilter, $em, $role, $idsalon, $column, $dir, $start, $length);
      else
        //Requete dans la bdd en fonction de la colonne et de la direction récupérée
        $demandes = $demandeRepo->wichService($role,$typeFilter,$column,$dir,$idsalon,$search,$start,$length);

      //Condition si aucune demandes n'est retournées
      if  (empty($demandes)){
        $output = array(
          'data' =>0,
          'recordsFiltered' => 0,
          'recordsTotal' => 0
        );
        return $output;

      } else {
        /* Compte du nombre de demande pour la pagination */
        $nb = $demandeRepo->getNb($role,$idsalon);
        $output = array(
          'data' => array(),
          'recordsFiltered' => $nb[0][1],
          'recordsTotal' => $nb[0][1]
        );

        /* Récupération des informations de chaque demande en fonction du type de demande  */
        $em = $this->getDoctrine()->getManager("referentiel");
        foreach ($demandes as $demande ) {
          $demandeur = $em->getRepository('ApiBundle:Personnel')
          ->findOneBy(array('matricule' => $demande->getUser()->getIdPersonnel()));

          /* Code Sage du salon concerné par la demande */
          $codeSage = $demande->getidSalon();

          /* Coordinateur du salon concerné par la demande */
          $coordo = $em->getRepository('ApiBundle:PersonnelHasSalon')->findOneBy(
            array("profession" => 2,
            "salonSage" => $codeSage,
          ));

          if (empty($coordo)){
            $coordo = 'n/a';
          } else {
            $coordo = $coordo->getPersonnelMatricule();
            $coordo = $coordo->getNom().' '.$coordo->getPrenom();
          }

          if (empty($demandeur)){
            $demandeur = 'n/a';
          } else {
            $demandeur = $demandeur->getNom().' '.$demandeur->getPrenom();
          }

          /* Nom et Prenom du personnel concerné par la demande  */
          if ($demande->getDemandeform()->getTypeForm() == "Demande d'acompte") {
            $idP = $demande->getDemandeform()->getIdPersonnel();
            $collab  = $persoRepo->whichPersonnel($demande,$idP);
          } else {
            $collab  = $demandeRepo->whichPersonnel($demande);
          }

          /* Statut de la demande  */
          $statut = $demandeRepo->whichStatut($demande);
          $classStatut= str_replace(' ', '_', $statut);
          /* Marque du salon concerné par la demande */
          $marque = $em->getRepository('ApiBundle:Salon')->findOneBy(
            array("sage" => $demande->getidSalon()))->getEnseigne()->getNom();

            /* Date de la demande */
            $date = $demande->getDateTraitement();

            /* Construction des lignes du tableau */
            $output['data'][] = [
              'id'               => $demande->getId(),
              ''                 => '<span class="glyphicon glyphicon-search click"></span>',
              'sage'             => $codeSage,
              'enseigne'         => $marque,
              'appelation'       => $em->getRepository('ApiBundle:Salon')->findOneBy(array("sage" => $demande->getidSalon()))->getAppelation(),
              'coordinateur'     => $coordo,
              'manager'          => $demandeur,
              'date'             => $date->format('d-m-Y H:i'),
              'statut'           => '<span class="'.$classStatut.' statutLabel">'.$statut.'</span>',
              'type'             => $demande->getDemandeform()->getTypeForm(),
              'collaborateur'    => $collab,
            ];
          }
          return $demandeRepo->sortingOut($typeFilter,$dir,$output,$column);
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

    // Filtrage des valeurs
    if ($request->get('extra'))
    {
      $typeFilter = $request->get('extra');
      return new Response(json_encode(self::displayDemandes($typeFilter,null,null,$idsalon,null,$start,$length)), 200, ['Content-Type' => 'application/json']);
    }


    //Affichage par défault sans filtre actif
    if ( !$request->get('order')){
      $typeFilter = 'init';
      return new Response(json_encode(self::displayDemandes($typeFilter,null,null,$idsalon,null,$start,$length)), 200, ['Content-Type' => 'application/json']);

      //Affichage lors d'un tri
    } else if ($request->get('order')) {
      //On récupère la colonne filtrée et la direction du tri
      $order = $request->get('order');
      $tri = $order[0]['column'];
      $dir = $order[0]['dir'];
      $columns = $request->get('columns');
      $column = $columns[$tri]['data'];
      $typeFilter = $columns[$tri]['name'];

      return new Response(json_encode(self::displayDemandes($typeFilter,$column,$dir,$idsalon,null,$start,$length)), 200, ['Content-Type' => 'application/json']);
    }
  }

  /**
   * @Route("/typeDemande", name="typeDemande")
   */
  public function typeDemande(Request $request)
  {
    $idDemande = $request->get('id');

    $entitym = $this->getDoctrine()->getManager();
    $demande = $entitym->getRepository('AppBundle:DemandeEntity')
                           ->findOneBy(array('id' => $idDemande));

     if ($demande instanceof DemandeSimple){
         $typedemande = 1;
        }else{
         $typedemande = 0;
          }
    return new Response(json_encode($typedemande), 200, ['Content-Type' => 'application/json']);

  }

}
