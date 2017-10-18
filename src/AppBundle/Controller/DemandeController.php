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

    public function displayDemandes($typeFilter,$column,$dir,$idsalon,$search,$start,$length){
        $entitym = $this->getDoctrine()->getManager();
        $demandeRepo = $entitym->getRepository('AppBundle:DemandeEntity');

        $em = $this->getDoctrine()->getManager('referentiel');
        $persoRepo = $em->getRepository('ApiBundle:Personnel');

        $role= $this->getUser()->getRoles();
        $role= $role[0];
        //Requete dans la bdd en fonction de la colonne et de la direction récupérée
        $demandes = $demandeRepo->wichService($role,$typeFilter,$column,$dir,$idsalon,$search,$start,$length);

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
                        "salonSage" => $demande->getidSalon(),
                    ))->getPersonnelMatricule();
                    $coordo = $coordo->getNom().' '.$coordo->getPrenom();

                /* Nom et Prenom du personnel concerné par la demande  */
                if ($demande->getDemandeform()->getTypeForm() == "Demande d'acompte"){
                     $idP = $demande->getDemandeform()->getIdPersonnel();
                     $collab  = $persoRepo->whichPersonnel($demande,$idP);
                     }else{
                     $collab  = $demandeRepo->whichPersonnel($demande);
                  }
                  
                /* Statut de la demande  */
                  $statut = $demandeRepo->whichStatut($demande);

                /* Marque du salon concerné par la demande */
                  $marque = $em->getRepository('ApiBundle:Salon')->findOneBy(
                  array("sage" => $demande->getidSalon()))->getEnseigne()->getNom();

                /* Date de la demande */
                  $date = $demande->getDateTraitement();

        /* Construction des lignes du tableau */
        $output['data'][] = [
          'id'               => $demande->getId(),
          ''                 => '<span class="glyphicon glyphicon-search click"></span>',
          'Code Sage'        => $codeSage,
          'Enseigne'         => $marque,
          'Appelation'       => $em->getRepository('ApiBundle:Salon')->findOneBy(array("sage" => $demande->getidSalon()))->getAppelation(),
          'Coordinateur'     => $coordo,
          'Manager'          => $demandeur->getNom() . " " . $demandeur->getPrenom(),
          'Date'             => $date->format('d-m-Y H:i'),
          'Statut'           => $statut,
          'Type de demande'  => $demande->getDemandeform()->getTypeForm(),
          'Collaborateur'    => $collab,
        ];
      }

      return $demandeRepo->sortingOut($typeFilter,$dir,$output,$column);
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

      return new Response(json_encode(self::displayDemandes($typeFilter,$column,$dir,$idsalon,null,$start,$length)), 200, ['Content-Type' => 'application/json']);
      }
  }
}
