<?php
namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\ORM\EntityManager;

class ImportService
{
  private $em;

  public function __construct(EntityManager $em)
  {
    $this->$em = $em;
  }

  public function importPersonnel()
  {

  }

  public function handleFile($file, $dir)
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
        $dir,
        $fileName
      );
    }
    else
    {
      // Efface le fichier et fais remonter l'erreur
      $fs->remove($file->getRealPath());
      throw new Exception('Type de fichier autre que CSV');
    }

    $csv = fopen($file->getRealPath(), "r");
    if (!$csv)
      throw new Exception('Fichier corrompu.');

    $file2 = $file;
    $testline = fgetcsv(fopen($file2->getRealPath(), "r"), 0, ";");

    $test = utf8_encode($testline[0]);
    if ($test == "Référence produit" || $test == "Référence produit X3")
      throw new Exception('Nom des colonnes ligne 1');

      $output_array = array();
    if (preg_match("/[{}=]/", $test, $output_array))
      throw new Exception('Information non conforme');


    if (count($testline) != 15)
        throw new Exception('Nombre de colonne attendu: 15, nombre détecté: ' . count($testline) );

    $array = $this->controleCsvLine($csv);

    // Ferme la lecture du fichier et le supprime
    fclose($csv);
    $fs->remove($file->getRealPath());

    return $array;
  }

  public function controleCsvLine($csv)
  {
    $i = 0;
    $array = array();
    $error = array();
    $iscontinue = true;

    while (($line = fgetcsv($csv, 0, ";")) != null)
    {
      // Clean chaques champs, si vide retourne null, sinon retourne en utf8
      $line = array_map(function($v){
        return ($v == "") ? NULL : utf8_encode($v);
      }, $line);

      // Vérifie le format de date et correction
      // $date =  DateTime::createFromFormat('Y-m-d', $line[2]);
      // if ($date) {
      //   $line[2] = $date->format('d/m/Y');
      //   $date2 =  DateTime::createFromFormat('Y-m-d', $line[4]);
      //   $line[4] = $date2->format('d/m/Y');
      // }

      $array[$i] = $line;

      // Champs obligatoire "Référence produit"
      if($line[0] == "" || $line[0] == null)
      $error[] =  "Champs obligatoire \"Référence produit\" absent à la ligne ".$i;

      // Champs obligatoire "Commande n°"
      if($line[1] == "" || $line[1] == null)
      $error[] = "Champs obligatoire \"Commande n°\" absent à la ligne " . $i;

      // Champs "N° de série"
      if($line[8] == "" || $line[8] == null)
      $error[] = "Champs obligatoire \"Champs N° de série\" absent à la ligne " . $i;

      // Controle de la continuité des numéros de série
      if(isset($tmp) && ($line[8] - $tmp) != 1)
      {
        $iscontinue = false;
        $error[] = "Numéro de série non continu à la ligne " . $i;
      }
      $tmp = $line[8];
      ++$i;
    }

    return array("error" => $error, "result" => $array, "count" => $i, "line" => $line);
  }
}
