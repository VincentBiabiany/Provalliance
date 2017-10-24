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
use AppBundle\Entity\DemandeComplexe;
use AppBundle\Entity\DemandeSimple;
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

        if ($request->get('origin')){
            return $this->render('demande.html.twig', array(
              'img' => $request->getSession()->get('img'),
              'flash'=> 'Confirmation de la validation des demandes.'
            ));
        }else{
              return $this->render('demande.html.twig', array(
                'img' => $request->getSession()->get('img'),
                'flash'=> null
              ));
          }
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

        //Condition si aucune demandes n'est retournées
        if  (empty($demandes)){
            $output = array(
               'data' =>0,
               'recordsFiltered' => 0,
               'recordsTotal' => 0
            );
            return $output;
        }else{
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
              'manager'          => $demandeur->getNom() . " " . $demandeur->getPrenom(),
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
  /**
   * @Route("/demandeValidate", name="demandeValidate")
   */
  public function demandeValidate(Request $request)
  {
    $demandeValidates = $request->get('demandes');

    $entitym = $this->getDoctrine()->getManager();
    foreach ($demandeValidates as $demandeValidate ) {
        $demande = $entitym->getRepository('AppBundle:DemandeEntity')
                            ->findOneBy(array('id' => $demandeValidate));

        $demande->setStatut(2);
        $this->getDoctrine()->getManager()->flush();
      }

      return new Response($this->generateUrl('demande',['origin' => 'validation']));

  }


}
