<?php
namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\TranslatorInterface;
use Doctrine\ORM\EntityManager;
use ApiBundle\Entity\Personnel;
use ApiBundle\Entity\Salon;
use ApiBundle\Entity\Groupe;
use ApiBundle\Entity\Enseigne;
use ApiBundle\Entity\Pays;
use ApiBundle\Entity\PersonnelHasSalon;
use ApiBundle\Entity\Profession;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Entity\DemandeEntity;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\PropertyInfo;

class ExportService
{
  private $em;
  private $em2;
  private $phpexcel;

  public function __construct(EntityManager $em, EntityManager $em2, \Liuggio\ExcelBundle\Factory $phpexcel)
  {
    $this->em           = $em;
    $this->em2          = $em2;
    $this->phpexcel     = $phpexcel;
  }

  public function createExcel($demandeExports)
  {
    $persoRepo = $this->em->getRepository('ApiBundle:Personnel');
    $demandeRepo = $this->em2->getRepository('AppBundle:DemandeEntity');
    $salonRepo = $this->em->getRepository('ApiBundle:Salon');
    $PersoHasSalonRepo = $this->em->getRepository('ApiBundle:PersonnelHasSalon');

    // Appel du service pour Excel5
    $phpExcelObject = $this->phpexcel->createPHPExcelObject();
    $i = 1;

    foreach ($demandeExports as $demandeExport ) {
      $j = $i + 1;

           //Infos de La demande
           $demandes = $demandeRepo->infosDemande($demandeExport);

           //Infos du salon
           $salon = $salonRepo->infosSalon($demandes['codeSage']);

           //Infos du coordinateur
           $coordo = $PersoHasSalonRepo->infosCoordinateur($demandes['codeSage']);

           //Infos du Collab
           $collabByDemande = $demandeRepo->collabByDemande($demandeExport);
           //Cas ou la demande concerne un nouveau collaborateur ( Demande d'embauche, demande d'essai ..ect)
           if ($collabByDemande['nameDemande'] == 'DemandeEmbauche'){
               $demandeSelfRepo = $this->em2->getRepository('AppBundle:'.$collabByDemande['nameDemande']);
               $collaborateur = $demandeSelfRepo->infosDemandeSelf($collabByDemande['demandeId']);

            //Cas ou la demande concerne un collaborateur existant
           }else{
              $demandeItSelf = $this->em2->getRepository('AppBundle:'.$collabByDemande['nameDemande'])
                                        ->findOneBy(array('id' => $collabByDemande['demandeId']));
              $collaborateur = $persoRepo->infosCollab($demandeItSelf->getidPersonnel());
           }
    $phpExcelObject->createSheet();
    // Colonnes Génériques
      if ($i ==1){
     $phpExcelObject->setActiveSheetIndex(0) ->setCellValue('A'.$i, 'Code SAGE salon')->setCellValue('B'.$i, 'Enseigne commerciale')->setCellValue('C'.$i, 'Appelation du salon')
      ->setCellValue('D'.$i, 'Forme juridique')->setCellValue('E'.$i, 'RCS ville')->setCellValue('F'.$i, 'Code NAF')->setCellValue('G'.$i, 'SIREN')
      ->setCellValue('H'.$i, 'Capital')->setCellValue('I'.$i, 'Raison sociale')->setCellValue('J'.$i, 'Adresse 1')->setCellValue('K'.$i, 'Adresse 2')
      ->setCellValue('L'.$i, 'Code postal')->setCellValue('M'.$i, 'Ville')->setCellValue('N'.$i, 'Pays')->setCellValue('O'.$i, 'Téléphone 1')
      ->setCellValue('P'.$i, 'Téléphone 2')->setCellValue('Q'.$i, 'Email')->setCellValue('R'.$i, 'Code MARLIX salon')->setCellValue('S'.$i, 'Date ouverture')
      ->setCellValue('T'.$i, 'Coordinateur')->setCellValue('U'.$i, 'Manager')->setCellValue('V'.$i, 'Responsable régional')
      ->setCellValue('W'.$i, 'N°matricule')->setCellValue('X'.$i, 'Civilité')->setCellValue('Y'.$i, 'Nom')
      ->setCellValue('Z'.$i, 'Prénom')->setCellValue('AA'.$i, 'Date naissance')->setCellValue('AB'.$i, 'Ville naissance')
      ->setCellValue('AC'.$i, 'Pays naissance')->setCellValue('AD'.$i, 'Sexe')->setCellValue('AE'.$i, 'Nationalité')->setCellValue('AF'.$i, 'Date entrée')
      ->setCellValue('AG'.$i, 'Date sortie')->setCellValue('AH'.$i, 'Niveau')->setCellValue('AI'.$i, 'Echelon')->setCellValue('AJ'.$i, 'Emploi')
      ->setCellValue('AK'.$i, 'Adresse 1')->setCellValue('AL'.$i, 'Adresse 2')->setCellValue('AM'.$i, 'Code postal')->setCellValue('AN'.$i, 'Ville')
      ->setCellValue('AO'.$i, 'Pays')->setCellValue('AP'.$i, 'Téléphone 1')->setCellValue('AQ'.$i, 'Téléphone 2')->setCellValue('AR'.$i, 'Email')
      ->setCellValue('AS'.$i, 'Date')->setCellValue('AT'.$i, 'Statut demande')->setCellValue('AU'.$i, 'Type demande');

          //Colonnes spécifiques à chaque demande
              $ColDemandes= self::whichCol($collabByDemande['nameDemande']);
              $tabExcelCol= array('AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BK','BL','BM','BN'
                            ,'BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG',
                            'CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
                            'DA','DB','DC','DD');

             for ($k = 0; $k < $ColDemandes['nb']; $k++) {
                $phpExcelObject->setActiveSheetIndex(0)->setCellValue($tabExcelCol[$k].$i, $ColDemandes['col'][$k]);

                  //Valeurs spécifiques à chaque propriété pour une demande
                  $valueCol= self::whichVal($collabByDemande['nameDemande'],$collabByDemande['demandeId'],$ColDemandes['col'][$k] );
                  $phpExcelObject->setActiveSheetIndex(0)->setCellValue($tabExcelCol[$k].$j, $valueCol);
             }
      }
     $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A'.$j, $demandes['codeSage'])->setCellValue('B'.$j, $salon['enseigne'])->setCellValue('C'.$j, $salon['appelation'])
      ->setCellValue('D'.$j, $salon['formeJuridique'])->setCellValue('E'.$j, $salon['rcsVille'])->setCellValue('F'.$j, $salon['codeNaf'])->setCellValue('G'.$j, $salon['siren'])
      ->setCellValue('H'.$j, $salon['capital'])->setCellValue('I'.$j, $salon['raisonSociale'])->setCellValue('J'.$j, $salon['adresse1'])->setCellValue('K'.$j, $salon['adresse2'])
      ->setCellValue('L'.$j, $salon['codePostal'])->setCellValue('M'.$j, $salon['ville'])->setCellValue('N'.$j, 'Pays')->setCellValue('O'.$j,$salon['telephone1'])
      ->setCellValue('P'.$j, $salon['telephone2'])->setCellValue('Q'.$j, $salon['email'])->setCellValue('R'.$j, $salon['codeMarlix'])->setCellValue('S'.$j,  $salon['dateOuverture']->format('d-m-Y'))
      ->setCellValue('T'.$j, $coordo['name'])->setCellValue('U'.$j,'manager')->setCellValue('V'.$j, 'Responsable régional')
      ->setCellValue('W'.$j, $collaborateur['matricule'])->setCellValue('X'.$j, 'Civilité')->setCellValue('Y'.$j, $collaborateur['nom'])->setCellValue('Z'.$j, $collaborateur['prenom'])->setCellValue('AA'.$j,$collaborateur["dateNaissance"])
      ->setCellValue('AB'.$j, $collaborateur['villeNaissance'])->setCellValue('AC'.$j, $collaborateur['paysNaissance'])->setCellValue('AD'.$j, $collaborateur['sexe'])->setCellValue('AE'.$j, $collaborateur['nationalite'])
      ->setCellValue('AF'.$j, $coordo['dateDeb'])->setCellValue('AG'.$j, $coordo['dateFin'])->setCellValue('AH'.$j, $collaborateur['niveau'])->setCellValue('AI'.$j,  $collaborateur['echelon'])
      ->setCellValue('AJ'.$j, $coordo['profession'])->setCellValue('AK'.$j, $collaborateur['adresse1'])->setCellValue('AL'.$j, $collaborateur['adresse2'])->setCellValue('AM'.$j, $collaborateur["codePostal"])
      ->setCellValue('AN'.$j, $collaborateur['ville'])->setCellValue('AO'.$j, 'Pays')->setCellValue('AP'.$j, $collaborateur['telephone1'])->setCellValue('AQ'.$j, $collaborateur['telephone2'])->setCellValue('AR'.$j, $collaborateur['email'])
      ->setCellValue('AS'.$j, $demandes['dateTraitement']->format('d-m-Y'))->setCellValue('AT'.$j, self::labelStatut($demandes['statut']))->setCellValue('AU'.$j, $collabByDemande['typeForm']);


    $phpExcelObject->getActiveSheet()->setTitle($collaborateur['nom'].'-'.$demandes['dateTraitement']->format('d-m-Y'));
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $phpExcelObject->setActiveSheetIndex(0);
    $i++;

    }
    // create the writer
    $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel5');
    // create the response
    $response =$this->phpexcel->createStreamedResponse($writer);
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

  //Fonction whichCol: Retourne les noms des différentes propriétés d'une entity et leur nombre
  //Paramètre : Entity Name
  //Return array
  public function whichCol($nameEntity){
      $reflectionExtractor = new ReflectionExtractor();
      $listExtractors = $reflectionExtractor;
      $propertyInfo = new PropertyInfoExtractor(array( $listExtractors ));
      $ColDemandes = [];

      $properties = $propertyInfo->getProperties('AppBundle\Entity\\'.$nameEntity);
      $properties = array_diff($properties,['discr','typeForm','id','nameDemande']);

      $ColDemandes['col']= $properties;
      $ColDemandes['nb']= count($properties);

      return $ColDemandes;

  }

  //Fonction whichVal: Retourne les noms des différentes propriétés d'une entity et leur nombre
  //Paramètre : Entity Name, Id Demande , Property Name
  //Return string
  public function whichVal($nameEntity,$idDemande,$nameProperty){
    $tableName = $this->em2->getClassMetadata('AppBundle:'.$nameEntity)->getTableName();
    $qb = $this->em2->createQueryBuilder()
                    ->add('select', 'u')
                    ->add('from', 'AppBundle:'.$nameEntity.' u')
                    ->add('where', 'u.id = :idDemande')
                    ->setParameter('idDemande', $idDemande)
                    ->getQuery()
                    ->getArrayResult();

                      return $result = $qb[0][$nameProperty];

}


  public function labelStatut($statut){

              switch ($statut) {
                      case 0:
                          $labelstatut= 'Rejeté';
                          break;
                      case 1:
                          $labelstatut= 'En cours';
                          break;
                      case 2:
                          $labelstatut= 'Traité';
                          break;
                      case 3:
                          $labelstatut= 'A signé';
                          break;
                      case 4:
                          $labelstatut= 'A validé';
                          break;
              }
    return $labelstatut;
        }

}
