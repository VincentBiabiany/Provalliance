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

class ImportService
{
  private $em;
  private $dir;
  private $trans;
  private  $batchSize = 70;

  public function __construct(EntityManager $em, TranslatorInterface $trans, $dir)
  {
    $this->em     = $em;
    $this->dir    = $dir;
    $this->trans  = $trans;
  }

  public function importPersonnel($file)
  {
    $champs = array(
                "champs"   => ["matricule"],
                "valeur"   => ["0"],
                "colonnes" => ["matricule","civilite","nom","prenom","date_naissance","ville_naissance","pays_naissance","sexe","nationalite","niveau","echelon","adresse1","adresse2","codepostal","ville","telephone","email","date_entree","date_sortie"],
                "nb"       => 19
              );
    $result = self::handleFile($file, $champs);

    $i = 0;
    foreach ($result["result"] as $key => $personnel)
    {
      $entity = $this->em->getRepository('ApiBundle:Personnel')->find($personnel[0]);

      if ($entity === null){
          $entity = (new Personnel())->setMatricule($personnel[0]);
      }

      $entity->setCivilite($personnel[1]);
      $entity->setNom($personnel[2]);
      $entity->setPrenom($personnel[3]);
      $entity->setDateNaissance(self::returnDate($personnel[4]));
      $entity->setVilleNaissance($personnel[5]);
      $entity->setPaysNaissance($personnel[6]);
      $entity->setSexe($personnel[7]);
      $entity->setNationalite($personnel[8]);
      $entity->setNiveau($personnel[9]);
      $entity->setEchelon($personnel[10]);
      $entity->setAdresse1($personnel[11]);
      $entity->setAdresse2($personnel[12]);
      $entity->setCodepostal($personnel[13]);
      $entity->setVille($personnel[14]);
      $entity->setTelephone1($personnel[15]);
      $entity->setEmail($personnel[16]);


      $entity->setDateEntree(self::returnDate($personnel[17]));
      $entity->setDateSortie(self::returnDate($personnel[18]));

      $entity->setActif(1);

      $this->em->persist($entity);
      if (($i % $this->batchSize) === 0) {
        $this->em->flush();
        $this->em->clear();
      }
      $i++;
    }
    $this->em->flush();
    $this->em->clear();
  }

  public function importSalon($file)
  {
    $champs = array(
                    "champs"   => ["Sage", "Groupe", "Enseigne", "Pays"],
                    "valeur"   => ["0", "19", "20", "21"],
                    "colonnes" => ["sage","appelation","forme_juridique","rcs_ville","code_naf","siren","capital","raison_sociale","adresse1","adresse2","code_postal","ville","telephone1","telephone2","email","code_marlix","date_ouverture","date_fermeture_sociale","date_fermeture_commerciale","groupe_id","enseigne_id","pays_id"],
                    "nb"       => 22
                  );

    $result = self::handleFile($file, $champs);

    $i = 0;


    foreach ($result["result"] as $key => $salon)
    {
      $entity = $this->em->getRepository('ApiBundle:Salon')->find($salon[0]);

      if ($entity === null)
        $entity = (new Salon())->setSage($salon[0]);

      $entity->setAppelation($salon[1]);
      $entity->setFormeJuridique($salon[2]);
      $entity->setRcsVille($salon[3]);
      $entity->setCodeNaf($salon[4]);
      $entity->setSiren($salon[5]);
      $entity->setCapital($salon[6]);
      $entity->setRaisonSociale($salon[7]);
      $entity->setAdresse1($salon[8]);
      $entity->setAdresse2($salon[9]);
      $entity->setCodePostal($salon[10]);
      $entity->setVille($salon[11]);
      $entity->setTelephone1($salon[12]);
      $entity->setTelephone2($salon[13]);
      $entity->setEmail($salon[14]);
      $entity->setCodeMarlix($salon[15]);
      $entity->setDateOuverture(self::returnDate($salon[16]));
      $entity->setDateFermetureSociale(self::returnDate($salon[17]));
      $entity->setDateFermetureCommerciale(self::returnDate($salon[18]));


      $group = $this->em->getRepository('ApiBundle:Groupe')->find($salon[19]);
      $entity->setGroupe($group);

      $enseigne = $this->em->getRepository('ApiBundle:Enseigne')->find($salon[20]);
      $entity->setEnseigne($enseigne);

      $pays = $this->em->getRepository('ApiBundle:Pays')->find($salon[21]);
      $entity->setPays($pays);

      $this->em->persist($entity);
      if (($i % $this->batchSize) === 0) {
          $this->em->flush();
          $this->em->clear(); // Detaches all objects from Doctrine!
       }
       $i++;
    }
    $this->em->flush();
    $this->em->clear();
  }


  public function returnDate($date)
  {
    $datet = $date;
    if ($date != null){
      $date =  \DateTime::createFromFormat('d/m/Y', $date);
      if (!$date)
        $date =  \DateTime::createFromFormat('Y-m-d', $datet);
    }
    else
      $date = \DateTime::createFromFormat('d/m/Y', '01/01/1970');

    return $date;
  }

  public function importLien($file)
  {
    $champs = array(
                    "champs"   => ["Matricule","Profession","Sage"],
                    "valeur"   => ["1", "2", "3"],
                    "colonnes" => ["id","personnel_matricule","profession_id","salon_sage","date_debut","date_fin"],
                    "nb"       => 6
                  );

    $result = self::handleFile($file, $champs);

    $i = 0;
    $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
    foreach ($result["result"] as $key => $lien)
    {
      $link = "{$lien[1]}{$lien[2]}{$lien[3]}";
      $entity = $this->em->getRepository('ApiBundle:PersonnelHasSalon')->find($lien[0]);

      if ($entity === null)
        $entity = (new PersonnelHasSalon())->setId($link);

      $profession = $this->em->getRepository('ApiBundle:Profession')->find($lien[2]);
      $entity->setProfession($profession);

      $personnel = $this->em->getRepository('ApiBundle:Personnel')->find($lien[1]);
      $entity->setPersonnelMatricule($personnel);

      $salon = $this->em->getRepository('ApiBundle:Salon')->find($lien[3]);
      $entity->setSalonSage($salon);

      $entity->setDateDebut(self::returnDate($lien[4]));
      $entity->setDateFin(self::returnDate($lien[5]));
      //$entity->setActif($lien[6]);


      $this->em->persist($entity);
       if (($i % $this->batchSize) === 0) {
          $this->em->flush();
          $this->em->clear(); // Detaches all objects from Doctrine!
       }
       $i++;
    }
    $this->em->flush();
    $this->em->clear();
  }

  public function handleFile($file, $champs)
  {
    // Control du type
    $mime = $file->getMimeType();
    $isexe = $file->isExecutable();
    $fs = new Filesystem();

    if ($mime == "text/plain"
        && $file->getClientMimeType() == "application/vnd.ms-excel"
        && ($file->getClientOriginalExtension() == "csv" || $file->getClientOriginalExtension() == "CSV")
        && $isexe == false)
    {
      // Génération d'un nom unique
      $fileName = md5(uniqid()). '.' . $file->guessExtension();

      // Place le fichier dans /web/upload/
      $file = $file->move(
        $this->dir,
        $fileName
      );
    } else {
      // Efface le fichier et fais remonter l'erreur
      $fs->remove($file->getRealPath());
      throw new Exception($this->trans->trans('import.nocsv', [],'translator'));
    }

    $csv = fopen($file->getRealPath(), "r");
    if (!$csv) {
      $fs->remove($file->getRealPath());
      throw new Exception($this->trans->trans('import.corrupt', [],'translator'));
    }
    // Test des noms de colonnes
    ini_set('auto_detect_line_endings', true);
    $head = fgetcsv($csv, 2000000, ';', '"');

    if (!($head == $champs["colonnes"])) {
      fclose($csv);
      $fs->remove($file->getRealPath());
      throw new Exception($this->trans->trans('import.nbchamps', ["%champs%"=>implode("\r",$champs["colonnes"]) ],'translator'));
    }

    $array = $this->controleCsvLine($csv, $champs);

    //Ferme la lecture du fichier et le supprime
    fclose($csv);
    $fs->remove($file->getRealPath());

    // Si problème dans les champs alors une exception est levée
    if (count($array["error"]) > 0) {
      $message = "";
      foreach ($array["error"] as $key => $value)
        $message .= $array["error"][$key] . "\n";
      throw new Exception($this->trans->trans('import.fileerror', [],'translator') ."\n\n" . $message, 1);
    }
    return $array;
  }

  public function controleCsvLine($csv, $chpObligatoire)
  {
    $i = 0;
    $array = array();
    $error = array();

    while (($line = fgetcsv($csv, 4096, ';', '"')) != null) {
      // Clean chaques champs, si vide retourne null, sinon retourne en utf8
      $line = array_map(function($v){
        return ($v == "") ? null : utf8_encode($v);
      }, $line);

      $array[$i] = $line;

      if (count($line) != $chpObligatoire["nb"])
        $error[] = $this->trans->trans('import.nb', [
                      "%line%"=> ($i + 2),
                      "%nb%" => count($line),
                      "%expd%" => $chpObligatoire["nb"]
                    ],
                      'translator'
              );

      foreach ($chpObligatoire["valeur"] as $key => $value) {
        if ($line[$value] == null)
          $error[] =  $this->trans->trans('import.champs',[
                        "%line%" => ($i + 2),
                        "%champs%" => $chpObligatoire["champs"][$key],
                      ],
                        'translator'
                    );
          self::testDbValue($line[$value], $chpObligatoire['colonnes'][$value], ($i + 2));
      }
      ++$i;
    }
    return array("error" => $error, "result" => $array, "count" => $i, "line" => $line);
  }

  public function testDbValue($value, $name, $line)
  {

    if ($name == "profession_id") {
      $profession = $this->em->getRepository('ApiBundle:Profession')->find($value);
      if (!$profession)
        throw new Exception($this->trans->trans('import.prof', ["%line%"=> $line],'translator'));
    }

    if ($name == "personnel_matricule") {
      $personnel = $this->em->getRepository('ApiBundle:Personnel')->find($value);
      if (!$personnel)
        throw new Exception($this->trans->trans('import.matr', ["%line%"=> $line], 'translator'));
    }

    if ($name == "salon_sage") {
      $salon = $this->em->getRepository('ApiBundle:Salon')->find($value);
      if (!$salon)
        throw new Exception($this->trans->trans('import.salonEr', ["%line%"=> $line],'translator'));
    }


    if ($name == "groupe_id") {
      $group = $this->em->getRepository('ApiBundle:Groupe')->find($value);
      if (!$group)
        throw new Exception($this->trans->trans('import.groupe', ["%line%"=> $line], 'translator'));
    }

    if ($name == "enseigne_id") {
      $enseigne = $this->em->getRepository('ApiBundle:Enseigne')->find($value);
      if (!$enseigne)
        throw new Exception($this->trans->trans('import.enseigne', ["%line%"=> $line], 'translator'));
    }

    if ($name == "pays_id") {
      $pays = $this->em->getRepository('ApiBundle:Pays')->find($value);
      if (!$pays)
        throw new Exception($this->trans->trans('import.pays', ["%line%"=> $line], 'translator'));
    }
  }
}
