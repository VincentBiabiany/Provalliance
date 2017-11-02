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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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

    // Appel du service pour Excel5
    $phpExcelObject = $this->phpexcel->createPHPExcelObject();
    $i = 0;
    foreach ($demandeExports as $demandeExport ) {
          // //Infos de La demande
          $demandes = $demandeRepo->infosDemande($demandeExport);

          //Infos de du salon
          $salon = $salonRepo->infosSalon($demandes['codeSage']);

          $coordo = $this->em->getRepository('ApiBundle:PersonnelHasSalon')->findOneBy(
          array("profession" => 2,
                "salonSage" => $demandes['codeSage'],
            ));
            if (empty($coordo)){
                $coordoName = 'n/a';
                $coordoDateDeb = 'n/a';
                $coordoDateFin = 'n/a';
                $coordoProfession = 'n/a';
            }else{
                $coordoName = $coordo->getPersonnelMatricule()->getNom().' '.$coordo->getPersonnelMatricule()->getPrenom();
                $coordoDateDeb = $coordo->getDateDebut()->format('d-m-Y');
                $coordoDateFin = $coordo->getDateFin()->format('d-m-Y');
                $coordoProfession = $coordo->getProfession()->getNom();
            }

           //Infos du Collab
           $demande = $this->em2->getRepository('AppBundle:DemandeEntity')
                             ->findOneBy(array('id' => $demandeExport));
           if ($demande->getDemandeform()->getTypeForm() == "Demande d'embauche"){
              //  $collab  = $demandeRepo->whichPersonnel($demande);
              $id = $demande->getDemandeform()->getId();
              $demandeEmbauche = $this->em2->getRepository('AppBundle:DemandeEmbauche')
                                ->findOneBy(array('id' => $id));

              $collaborateurMatricule      = '';
              $collaborateurNom            = $demandeEmbauche->getNom();
              $collaborateurPrenom         = '';
              $collaborateurDateNaissance  = $demandeEmbauche->getDateNaissance()->format('d-m-Y');
              $collaborateurVilleNaissance = $demandeEmbauche->getVilleNaissance();
              $collaborateurPaysNaissance  = $demandeEmbauche->getPaysNaissance();
              $collaborateurDateNaissance  = $demandeEmbauche->getDateNaissance()->format('d-m-Y');
              $collaborateurSexe           = $demandeEmbauche->getSexe();
              $collaborateurNationalite    = $demandeEmbauche->getNationalite();
              $collaborateurNiveau         = $demandeEmbauche->getNiveau();
              $collaborateurEchelon        = $demandeEmbauche->getEchelon();
              $collaborateurAdresse1       = $demandeEmbauche->getAddresse1();
              $collaborateurAdresse2       = $demandeEmbauche->getAddresse2();
              $collaborateurCodepostal     = $demandeEmbauche->getCodepostal();
              $collaborateurVille          = $demandeEmbauche->getVille();
              $collaborateurTelephone1     = $demandeEmbauche->getTelephone();
              $collaborateurTelephone2     = '';
              $collaborateurEmail          = $demandeEmbauche->getEmail();

                }else{
               $id = $demande->getDemandeform()->getId();
               $demandeAcompte = $this->em2->getRepository('AppBundle:DemandeAcompte')
                                    ->findOneBy(array('id' => $id));

              $idP = $demandeAcompte->getidPersonnel();
              $collaborateur = $this->em->getRepository('ApiBundle:Personnel')
                                   ->findOneBy(array('matricule' => $idP));

              $collaborateurMatricule      = $collaborateur->getMatricule();
              $collaborateurNom            = $collaborateur->getNom();
              $collaborateurPrenom         = $collaborateur->getPrenom();
              $collaborateurDateNaissance  = $collaborateur->getDateNaissance()->format('d-m-Y');
              $collaborateurVilleNaissance = $collaborateur->getVilleNaissance();
              $collaborateurPaysNaissance  = $collaborateur->getPaysNaissance();
              $collaborateurDateNaissance  = $collaborateur->getDateNaissance()->format('d-m-Y');
              $collaborateurSexe           = $collaborateur->getSexe();
              $collaborateurNationalite    = $collaborateur->getNationalite();
              $collaborateurNiveau         = $collaborateur->getNiveau();
              $collaborateurEchelon        = $collaborateur->getEchelon();
              $collaborateurAdresse1       = $collaborateur->getAdresse1();
              $collaborateurAdresse2       = $collaborateur->getAdresse2();
              $collaborateurCodepostal     = $collaborateur->getCodepostal();
              $collaborateurVille          = $collaborateur->getVille();
              $collaborateurTelephone1     = $collaborateur->getTelephone1();
              $collaborateurTelephone2     = $collaborateur->getTelephone2();
              $collaborateurEmail          = $collaborateur->getEmail();
              }

           /* Type de la demande  */
           $demandeType = $demande->getDemandeform()->getTypeForm();

          //  $this->getDoctrine()->getManager()->flush();

    $phpExcelObject->createSheet();
    $phpExcelObject->setActiveSheetIndex($i)
      ->setCellValue('A1', 'Code SAGE salon')->setCellValue('A2', 'Enseigne commerciale')->setCellValue('A3', 'Appelation du salon')
      ->setCellValue('A4', 'Forme juridique')->setCellValue('A5', 'RCS ville')->setCellValue('A6', 'Code NAF')->setCellValue('A7', 'SIREN')
      ->setCellValue('A8', 'Capital')->setCellValue('A9', 'Raison sociale')->setCellValue('A10', 'Adresse 1')->setCellValue('A11', 'Adresse 2')
      ->setCellValue('A12', 'Code postal')->setCellValue('A13', 'Ville')->setCellValue('A14', 'Pays')->setCellValue('A15', 'Téléphone 1')
      ->setCellValue('A16', 'Téléphone 2')->setCellValue('A17', 'Email')->setCellValue('A18', 'Code MARLIX salon')->setCellValue('A19', 'Date ouverture')
      ->setCellValue('A20', 'Coordinateur')->setCellValue('A21', 'Manager')->setCellValue('A22', 'Responsable régional')
      ->setCellValue('A23', 'N°matricule')->setCellValue('A24', 'Civilité')->setCellValue('A25', 'Nom')
      ->setCellValue('A26', 'Prénom')->setCellValue('A27', 'Date naissance')->setCellValue('A28', 'Ville naissance')
      ->setCellValue('A29', 'Pays naissance')->setCellValue('A30', 'Sexe')->setCellValue('A31', 'Nationalité')->setCellValue('A32', 'Date entrée')
      ->setCellValue('A33', 'Date sortie')->setCellValue('A34', 'Niveau')->setCellValue('A35', 'Echelon')->setCellValue('A36', 'Emploi')
      ->setCellValue('A37', 'Adresse 1')->setCellValue('A38', 'Adresse 2')->setCellValue('A39', 'Code postal')->setCellValue('A40', 'Ville')
      ->setCellValue('A41', 'Pays')->setCellValue('A42', 'Téléphone 1')->setCellValue('A43', 'Téléphone 2')->setCellValue('A44', 'Email')
      ->setCellValue('A45', 'Date')->setCellValue('A46', 'Statut demande')->setCellValue('A47', 'Type demande')
      ->setCellValue('B1', $demandes['codeSage'])->setCellValue('B2', $salon['enseigne'])->setCellValue('B3', $salon['appelation'])
      ->setCellValue('B4', $salon['formeJuridique'])->setCellValue('B5', $salon['rcsVille'])->setCellValue('B6', $salon['codeNaf'])->setCellValue('B7', $salon['siren'])
      ->setCellValue('B8', $salon['capital'])->setCellValue('B9', $salon['raisonSociale'])->setCellValue('B10', $salon['adresse1'])->setCellValue('B11', $salon['adresse2'])
      ->setCellValue('B12', $salon['codePostal'])->setCellValue('B13', $salon['ville'])->setCellValue('B14', 'Pays')->setCellValue('B15',$salon['telephone1'])
      ->setCellValue('B16', $salon['telephone2'])->setCellValue('B17', $salon['email'])->setCellValue('B18', $salon['codeMarlix'])->setCellValue('B19',  $salon['dateOuverture']->format('d-m-Y'))
      ->setCellValue('B20', $coordoName)->setCellValue('B21','manager')->setCellValue('B22', 'Responsable régional')
      ->setCellValue('B23', $collaborateurMatricule)->setCellValue('B24', 'Civilité')->setCellValue('B25', $collaborateurNom)->setCellValue('B26', $collaborateurPrenom)->setCellValue('B27',$collaborateurDateNaissance)
      ->setCellValue('B28', $collaborateurVilleNaissance)->setCellValue('B29', $collaborateurPaysNaissance)->setCellValue('B30', $collaborateurSexe)->setCellValue('B31', $collaborateurNationalite)
      ->setCellValue('B32', $coordoDateDeb)->setCellValue('B33', $coordoDateFin)->setCellValue('B34', $collaborateurNiveau)->setCellValue('B35',  $collaborateurEchelon)
      ->setCellValue('B36', $coordoProfession)->setCellValue('B37', $collaborateurAdresse1)->setCellValue('B38', $collaborateurAdresse2)->setCellValue('B39', $collaborateurCodepostal)
      ->setCellValue('B40', $collaborateurVille)->setCellValue('B41', 'Pays')->setCellValue('B42', $collaborateurTelephone1)->setCellValue('B43', $collaborateurTelephone2)->setCellValue('B44', $collaborateurEmail)
      ->setCellValue('B45', $demandes['dateTraitement']->format('d-m-Y'))->setCellValue('B46', self::labelStatut($demandes['statut']))->setCellValue('B47', $demandeType);

    $phpExcelObject->getActiveSheet()->setTitle($collaborateurNom.'-'.$demandes['dateTraitement']->format('d-m-Y'));
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
