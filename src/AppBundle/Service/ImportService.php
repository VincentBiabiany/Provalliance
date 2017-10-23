<?php
namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
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

  public function __construct(EntityManager $em, $dir)
  {
    $this->em = $em;
    $this->dir = $dir;
  }

  public function importPersonnel($file)
  {
    $champs = array(
                "champs" => ["matricule"],
                "valeur" => ["0"],
                "nb"     => 19
              );
    $result = self::handleFile($file, $champs);

    dump($result);

    foreach ($result["result"] as $key => $personnel)
    {
      $entity = $this->em->getRepository('ApiBundle:Personnel')->find($personnel[0]);

      if ($entity === null)
        $entity = new Personnel();

      $entity->setCivilite($personnel[1]);
      $entity->setNom($personnel[2]);
      $entity->setPrenom($personnel[3]);

      $date = \DateTime::createFromFormat('d/m/Y H:i', $personnel[4]);
      $entity->setDateNaissance($date);

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
      $entity->setTelephone2($personnel[16]);
      $entity->setEmail($personnel[17]);
      $entity->setActif($personnel[18]);

      $this->em->persist($entity);
      $this->em->flush();
    }
  }

  public function importSalon($file)
  {
    $champs = array(
                    "champs" => ["Sage", "Groupe", "Enseigne", "Pays"],
                    "valeur" => ["0", "20", "21", "22"],
                    "nb"     => 23
                  );

    $result = self::handleFile($file, $champs);

    foreach ($result["result"] as $key => $salon)
    {
      $entity = $this->em->getRepository('ApiBundle:Salon')->find($salon[0]);

      if ($entity === null)
        $entity = new Salon();

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

      $date =  \DateTime::createFromFormat('d/m/Y H:i', $salon[16]);
      $entity->setDateOuverture($date);

      $date =  \DateTime::createFromFormat('d/m/Y H:i', $salon[17]);
      $entity->setDateFermetureSociale($date);

      $date =  \DateTime::createFromFormat('d/m/Y H:i', $salon[18]);
      $entity->setDateFermetureCommerciale($date);

      $entity->setActif($salon[19]);

      $group = $this->em->getRepository('ApiBundle:Groupe')->find($salon[20]);
      if (!$group)
        throw new Exception('Le groupe ligne ' . $key+2 .' n\'existe pas');
      $entity->setGroupe($group);

      $enseigne = $this->em->getRepository('ApiBundle:Enseigne')->find($salon[21]);
      if (!$enseigne)
        throw new Exception('L\'enseigne ligne ' . $key+2 .'n\'existe pas');
      $entity->setEnseigne($enseigne);

      $pays = $this->em->getRepository('ApiBundle:Pays')->find($salon[22]);
      if (!$pays)
        throw new Exception('Le pays ligne ' . $key+2 .'n\'existe pas');

      $entity->setPays($pays);

      $this->em->persist($entity);
      $this->em->flush();
    }
  }

  public function importLien($file)
  {
    $champs = array(
                    "champs" => ["Profession", "Matricule", "Sage"],
                    "valeur" => ["0", "1", "2"],
                    "nb"     => 6
                  );

    $result = self::handleFile($file, $champs);

    dump($result);
    foreach ($result["result"] as $key => $lien)
    {
      dump($lien);
      //$entity = $this->em->getRepository('ApiBundle:PersonnelHasSalon')->find($lien[0]);


        $entity = new PersonnelHasSalon();

      $profession = $this->em->getRepository('ApiBundle:Profession')->find($lien[0]);
      if (!$profession)
        throw new Exception('La profession ligne ' . $key+2 .' n\'existe pas');
      $entity->setProfession($profession);

      $personnel = $this->em->getRepository('ApiBundle:Personnel')->find($lien[1]);
      if (!$personnel)
        throw new Exception('Le matricule ligne ' . $key+2 .' n\'existe pas');
      $entity->setPersonnelMatricule($personnel);

      $salon = $this->em->getRepository('ApiBundle:Salon')->find($lien[2]);
      if (!$salon)
        throw new Exception('Le salon ligne ' . $key+2 .' n\'existe pas');
      $entity->setSalonSage($salon);

      $date =  \DateTime::createFromFormat('d/m/Y H:i', $lien[3]);
      $entity->setDateDebut($date);

      $date =  \DateTime::createFromFormat('d/m/Y H:i', $lien[4]);
      $entity->setDateFin($date);

      $entity->setActif($lien[5]);

      $this->em->persist($entity);
      $this->em->flush();
    }
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
    }
    else
    {
      // Efface le fichier et fais remonter l'erreur
      throw new Exception('Type de fichier autre que CSV');
    }

    $csv = fopen($file->getRealPath(), "r");
    if (!$csv)
    {
      $fs->remove($file->getRealPath());
      throw new Exception('Fichier corrompu.');
    }

    $array = $this->controleCsvLine($csv, $champs);

    //Ferme la lecture du fichier et le supprime
    fclose($csv);
    $fs->remove($file->getRealPath());

    // Si problème dans les champs alors une exception est levée
    if (count($array["error"]) != 0) {
      foreach ($array["error"] as $key => $value)
        $message .= $array["error"][$key] . "\n";
      throw new Exception("Erreur dans le fichier: " . $message, 1);
    }

    return $array;
  }

  public function controleCsvLine($csv, $chpObligatoire)
  {
    $i = 0;
    $array = array();
    $error = array();

    $head = fgetcsv($csv);

    while (($line = fgetcsv($csv)) != null)
    {
      // Clean chaques champs, si vide retourne null, sinon retourne en utf8
      $line = array_map(function($v){
        return ($v == "") ? null : utf8_encode($v);
      }, $line);

      $array[$i] = $line;

      if (count($line) != $chpObligatoire["nb"])
        $error[] = "Problème de nombre de champs ligne " . $i . " nombre : " . count($line) . " attendu : " . $chpObligatoire["nb"];

      foreach ($chpObligatoire["valeur"] as $key => $value) {
        if ($line[$value] == null)
          $error[] =  "Champs obligatoire '" . $chpObligatoire["champs"][$key] . "' absent à la ligne " . $i;
      }
      ++$i;
    }
    return array("error" => $error, "result" => $array, "count" => $i, "line" => $line);
  }
}
