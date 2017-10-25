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
        if ($request->get('origin')){
            return $this->render('demande.html.twig', array(
              'img' => $request->getSession()->get('img'),
              'flash'=> 'Confirmation de la validation des demandes.',
              'form' => $form->createView()
            ));
        }else{
              return $this->render('demande.html.twig', array(
                'img' => $request->getSession()->get('img'),
                'flash'=> null,
                'form' => $form->createView()
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

  /**
   * @Route("/exportXls", name="exportXls")
   */
  public function exportXls(Request $request)
  {
      $formData = $request->get('form');
      $demandeExports = explode(',',$formData['idDemandes']);

      $entitym = $this->getDoctrine()->getManager();
      $em = $this->getDoctrine()->getManager('referentiel');
      $persoRepo = $em->getRepository('ApiBundle:Personnel');
      $demandeRepo = $entitym->getRepository('AppBundle:DemandeEntity');
            // ask the service for a Excel5
          $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

          $phpExcelObject->getProperties()->setCreator("liuggio")
              ->setLastModifiedBy("Giulio De Donato")
              ->setTitle("Office 2005 XLSX Test Document")
              ->setSubject("Office 2005 XLSX Test Document")
              ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
              ->setKeywords("office 2005 openxml php")
              ->setCategory("Test result file");

      $i = 0;
      foreach ($demandeExports as $demandeExport ) {
            //Infos de La demande
            $demande = $entitym->getRepository('AppBundle:DemandeEntity')
                              ->findOneBy(array('id' => $demandeExport));

            $statut = $demande->getStatut();
            $date =  $demande->getDateTraitement();
            $userId =  $demande->getUser();
            $codeSage =  $demande->getIdSalon();

            //Infos de du salon
            $salon = $em->getRepository('ApiBundle:Salon')
                          ->findOneBy(array('sage' => $codeSage));

            $appelation = $salon->getAppelation();
            $enseigne = $salon->getEnseigne()->getNom();

            /* Coordinateur du salon concerné par la demande */
            $coordo = $em->getRepository('ApiBundle:PersonnelHasSalon')->findOneBy(
            array("profession" => 2,
                  "salonSage" => $demande->getidSalon(),
             ));

             //Infos du Demandeur
             $demandeur = $em->getRepository('ApiBundle:Personnel')
                             ->findOneBy(array('matricule' => $demande->getUser()->getIdPersonnel()));
             $demandeur->getNom() . " " . $demandeur->getPrenom();

             /* Nom et Prenom du personnel concerné par la demande  */
             if ($demande->getDemandeform()->getTypeForm() == "Demande d'acompte"){
                  $idP = $demande->getDemandeform()->getIdPersonnel();
                  $collab  = $persoRepo->whichPersonnel($demande,$idP);
                  }else{
                  $collab  = $demandeRepo->whichPersonnel($demande);
                }

             /* Type de la demande  */
             $type = $demande->getDemandeform()->getTypeForm();

             $this->getDoctrine()->getManager()->flush();

    $phpExcelObject->createSheet();
    $phpExcelObject->setActiveSheetIndex($i)
        ->setCellValue('A1', 'Code SAGE salon')->setCellValue('A2', 'Enseigne commerciale')->setCellValue('A3', 'Appelation du salon')
        ->setCellValue('A4', 'Forme juridique')->setCellValue('A5', 'RCS ville')->setCellValue('A6', 'Code NAF')->setCellValue('A7', 'SIREN')
        ->setCellValue('A8', 'Capital')->setCellValue('A9', 'Raison sociale')->setCellValue('A10', 'adresse 1')->setCellValue('A11', 'adresse 2')
        ->setCellValue('A12', 'code postal')->setCellValue('A13', 'Ville')->setCellValue('A14', 'Pays')->setCellValue('A15', 'Téléphone 1')
        ->setCellValue('A16', 'Téléphone 2')->setCellValue('A17', 'email')->setCellValue('A18', 'Code MARLIX salon')->setCellValue('A19', 'Date ouverture')
        ->setCellValue('A20', 'Coordinateur')->setCellValue('A21', 'Manager')->setCellValue('A22', 'Responsable régional')
        ->setCellValue('A23', 'N°matricule')->setCellValue('A24', 'Civilité')->setCellValue('A25', 'Nom')
        ->setCellValue('A26', 'Prénom')->setCellValue('A27', 'Date naissance')->setCellValue('A28', 'Ville naissance')
        ->setCellValue('A29', 'Pays naissance')->setCellValue('A30', 'Sexe')->setCellValue('A31', 'Nationalité')->setCellValue('A32', 'Date entrée')
        ->setCellValue('A33', 'Date sortie')->setCellValue('A34', 'Niveau')->setCellValue('A35', 'Echelon')->setCellValue('A36', 'Emploi')
        ->setCellValue('A37', 'adresse 1')->setCellValue('A38', 'adresse 2')->setCellValue('A39', 'code postal')->setCellValue('A40', 'Ville')
        ->setCellValue('A41', 'Pays')->setCellValue('A42', 'Téléphone 1')->setCellValue('A43', 'Téléphone 2')->setCellValue('A44', 'email')
        ->setCellValue('A45', 'date')->setCellValue('A46', 'statut demande')->setCellValue('A47', 'type demande')
        ->setCellValue('B1', $codeSage)->setCellValue('B2', $enseigne)->setCellValue('B3', $salon->getAppelation())
        ->setCellValue('B4', $salon->getFormeJuridique())->setCellValue('B5', $salon->getRcsVille())->setCellValue('B6', $salon->getCodeNaf())->setCellValue('B7', $salon->getSiren())
        ->setCellValue('B8', $salon->getCapital())->setCellValue('B9', $salon->getRaisonSociale())->setCellValue('B10', $salon->getAdresse1())->setCellValue('B11', $salon->getAdresse2())
        ->setCellValue('B12', $salon->getCodePostal())->setCellValue('B13', $salon->getVille())->setCellValue('B14', 'Pays')->setCellValue('B15',  $salon->getTelephone1())
        ->setCellValue('B16', $salon->getTelephone2())->setCellValue('B17', $salon->getEmail())->setCellValue('B18', $salon->getCodeMarlix())->setCellValue('B19',  $salon->getDateOuverture())
        ->setCellValue('B20', $coordo->getPersonnelMatricule()->getNom().' '.$coordo->getPersonnelMatricule()->getPrenom())->setCellValue('B21','manager')->setCellValue('B22', 'Responsable régional')
        ->setCellValue('B23', 'N°matricule')->setCellValue('B24', 'Civilité')->setCellValue('B25', $demandeur->getNom())
        ->setCellValue('B26', $demandeur->getPrenom())->setCellValue('B27', $demandeur->getDateNaissance())->setCellValue('B28', $demandeur->getVilleNaissance())
        ->setCellValue('B29', $demandeur->getVilleNaissance())->setCellValue('B30', $demandeur->getSexe())->setCellValue('B31', $demandeur->getNationalite())->setCellValue('B32', 'Date entrée')
        ->setCellValue('B33', 'Date sortie')->setCellValue('B34', $demandeur->getNiveau())->setCellValue('B35',  $demandeur->getEchelon())->setCellValue('B36', $coordo->getProfession()->getNom())
        ->setCellValue('B37', $demandeur->getAdresse1())->setCellValue('B38', $demandeur->getAdresse2())->setCellValue('B39', $demandeur->getCodepostal())->setCellValue('B40',$demandeur->getVille())
        ->setCellValue('B41', 'Pays')->setCellValue('B42', $demandeur->getTelephone1())->setCellValue('B43', $demandeur->getTelephone2())->setCellValue('B44', $demandeur->getEmail())
        ->setCellValue('B45', $date)->setCellValue('B46', $statut)->setCellValue('B47', $type);

    $phpExcelObject->getActiveSheet()->setTitle($demandeur->getNom().'-'.$date->format('d-m-Y'));
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $phpExcelObject->setActiveSheetIndex(0);

     $i++;

  }
    // create the writer
    $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
    // create the response
    $response = $this->get('phpexcel')->createStreamedResponse($writer);
    // adding headers
    $dispositionHeader = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'Export_'.date('d-m-Y').'.xls'
    );
    $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
    $response->headers->set('Pragma', 'public');
    $response->headers->set('Cache-Control', 'maxage=1');
    $response->headers->set('Content-Disposition', $dispositionHeader);
     return $response;
  }

}
