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

  public function __construct(EntityManager $em, TranslatorInterface $trans, $dir)
  {
    $this->em     = $em;
    $this->dir    = $dir;
    $this->trans  = $trans;
  }

  public function importPersonnel($file)
  {
    $champs = array(
                "champs" => ["matricule"],
                "valeur" => ["0"],
                "nb"     => 19
              );
    $result = self::handleFile($file, $champs);

    // dump($result);
    foreach ($result["result"] as $key => $personnel)
    {
      $entity = $this->em->getRepository('ApiBundle:Personnel')->find($personnel[0]);

      if ($entity === null)
        $entity = new Personnel();

      $entity->setCivilite($personnel[1]);
      $entity->setNom($personnel[2]);
      $entity->setPrenom($personnel[3]);

      if ($personnel[4] != null)
        $date = \DateTime::createFromFormat('d/m/Y H:i', $personnel[4]);
      else
        $date = \DateTime::createFromFormat('d/m/Y H:i', '01/01/1970 00:00');

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

      if ($salon[16] != null)
        $date =  \DateTime::createFromFormat('d/m/Y H:i', $salon[16]);
      else
        $date = \DateTime::createFromFormat('d/m/Y H:i', '01/01/1970 00:00');
      $entity->setDateOuverture($date);

      if ($salon[17] != null)
        $date =  \DateTime::createFromFormat('d/m/Y H:i', $salon[17]);
      else
        $date = \DateTime::createFromFormat('d/m/Y H:i', '01/01/1970 00:00');
      $entity->setDateFermetureSociale($date);

      if ($salon[18] != null)
        $date =  \DateTime::createFromFormat('d/m/Y H:i', $salon[18]);
      else
        $date = \DateTime::createFromFormat('d/m/Y H:i', '01/01/1970 00:00');
      $entity->setDateFermetureCommerciale($date);

      $entity->setActif($salon[19]);

      $group = $this->em->getRepository('ApiBundle:Groupe')->find($salon[20]);
      if (!$group)
        throw new Exception($this->trans->trans('import.groupe', ["%line%"=> ($key+1)],'import'));
      $entity->setGroupe($group);

      $enseigne = $this->em->getRepository('ApiBundle:Enseigne')->find($salon[21]);
      if (!$enseigne)
        throw new Exception($this->trans->trans('import.enseigne', ["%line%"=> ($key+1)],'import'));
      $entity->setEnseigne($enseigne);

      $pays = $this->em->getRepository('ApiBundle:Pays')->find($salon[22]);
      if (!$pays)
        throw new Exception($this->trans->trans('import.pays', ["%line%"=> ($key+1)],'import'));

      $entity->setPays($pays);

      $this->em->persist($entity);
      $this->em->flush();
    }
  }

  public function importLien($file)
  {
    $champs = array(
                    "champs" => ["Profession", "Matricule", "Sage"],
                    "valeur" => ["2", "1", "3"],
                    "nb"     => 7
                  );

    $result = self::handleFile($file, $champs);

    // dump($result);
    foreach ($result["result"] as $key => $lien)
    {
      //dump($lien);
      $entity = $this->em->getRepository('ApiBundle:PersonnelHasSalon')->find($lien[0]);

      if ($entity === null)
        $entity = new PersonnelHasSalon();

      $profession = $this->em->getRepository('ApiBundle:Profession')->find($lien[2]);
      if (!$profession)
        throw new Exception($this->trans->trans('import.prof', ["%line%"=> ($key+1)],'import'));
      $entity->setProfession($profession);

      $personnel = $this->em->getRepository('ApiBundle:Personnel')->find($lien[1]);
      if (!$personnel)
        throw new Exception($this->trans->trans('import.matr', ["%line%"=> ($key+1)],'import'));
      $entity->setPersonnelMatricule($personnel);

      $salon = $this->em->getRepository('ApiBundle:Salon')->find($lien[3]);
      if (!$salon)
        throw new Exception($this->trans->trans('import.salonEr', ["%line%"=> ($key+1)],'import'));
      $entity->setSalonSage($salon);

      if ($lien[4] != null)
        $date =  new \DateTime($lien[4]);
      else
        $date =  \DateTime::createFromFormat('d/m/Y H:i', '01/01/1970 00:00');
      $entity->setDateDebut($date);

      if ($lien[5] != null)
        $date =  new \DateTime($lien[5]);
      else
        $date = \DateTime::createFromFormat('d/m/Y H:i', '01/01/1970 00:00');
      $entity->setDateFin($date);

      $entity->setActif($lien[6]);

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
      throw new Exception($this->trans->trans('import.nocsv', [],'import'));
    }

    $csv = fopen($file->getRealPath(), "r");
    if (!$csv)
    {
      $fs->remove($file->getRealPath());
      throw new Exception($this->trans->trans('import.corrupt', [],'import'));
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
      throw new Exception($this->trans->trans('import.fileerror', [],'import') ."\n\n" . $message, 1);
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
        $error[] = $this->trans->trans('import.nb', [
                      "%line%"=> ($i + 1 ),
                      "%nb%" => count($line),
                      "%expd%" => $chpObligatoire["nb"]
                    ],
                      'import'
              );

      foreach ($chpObligatoire["valeur"] as $key => $value) {
        if ($line[$value] == null)
          $error[] =  $this->trans->trans('import.champs',[
                        "%line%" => ($i + 1),
                        "%champs%" => $chpObligatoire["champs"][$key],
                      ],
                        'import'
                    );
      }
      ++$i;
    }
    return array("error" => $error, "result" => $array, "count" => $i, "line" => $line);
  }
}
