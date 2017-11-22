<?php
namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Doctrine\ORM\EntityManager;
use ApiBundle\Entity\Personnel;
use ApiBundle\Entity\PersonnelHasSalon;
use ApiBundle\Entity\Profession;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Entity\AutreDemande;
use AppBundle\Entity\DemandeEntity;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\PropertyInfo;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Routing\Router;

class ResumeDemandeService
{
  private $em;
  private $em2;
  private $translator;
  private $propertyInfo;
  private $nameEntity;
  private $router;

  public function __construct(EntityManager $em, EntityManager $em2, Translator $translator, Router $router)
  {
    $this->em           = $em;
    $this->em2          = $em2;
    $this->translator   = $translator;
    $this->router       = $router;
  }

  public function generateAbsUrl($doc)
  {
    $url = $this->url = $this->router->generate('homepage', [], 0);
    return $url .=  __DIR__.'/../../../../web/uploads/files/' . $doc;
  }

  public function generateResume($idDemandes,$action)
  {

    $phpDocExtractor = new PhpDocExtractor();
    $reflectionExtractor = new ReflectionExtractor();

    // array of PropertyListExtractorInterface
    $listExtractors = array($reflectionExtractor);

    // array of PropertyTypeExtractorInterface
    $typeExtractors = array($phpDocExtractor, $reflectionExtractor);

    // array of PropertyDescriptionExtractorInterface
    $descriptionExtractors = array($phpDocExtractor);

    // array of PropertyAccessExtractorInterface
    $accessExtractors = array($reflectionExtractor);

    $propertyInfo = new PropertyInfoExtractor(
      $listExtractors,
      $typeExtractors,
      $descriptionExtractors,
      $accessExtractors
    );

    $this->propertyInfo = $propertyInfo;

    //Repository
    $demandeRepo = $this->em2->getRepository('AppBundle:DemandeEntity');
    $salonRepo = $this->em->getRepository('ApiBundle:Salon');
    $persoRepo = $this->em->getRepository('ApiBundle:Personnel');

    //Var For HTML
    $response = '';
    $fileList = '';

    //Path
    $package = new PathPackage('uploads/files', new EmptyVersionStrategy());

    //1 demande par page
    foreach ($idDemandes as $idDemande ) {

      $infoDemande = $demandeRepo->infosDemande($idDemande);
      $infosCollab = $persoRepo->InfosCollab($infoDemande['userID']);

      $nameEntity = $infoDemande['nameDemande'];
      $idDemandeItSelf = $infoDemande['demandeId'];
      $this->nameEntity = $nameEntity;

      // Recupération de la demande
      $qb = $this->em2->createQueryBuilder()
                      ->add('select', 'u')
                      ->add('from', 'AppBundle:'.$nameEntity.' u')
                      ->add('where', 'u.id = :idDemande')
                      ->setParameter('idDemande', $idDemandeItSelf)
                      ->getQuery()
                      ->getArrayResult();


      // Récupération des noms des propriétés de l'entité
      $properties = $propertyInfo->getProperties('AppBundle\Entity\\'.$nameEntity);

      $properties = array_diff($properties, ['discr', 'typeForm', 'id', 'nameDemande', 'subject', 'service', 'nomDoc']);

      $response .= '<div class="page">';
      $response .= '<h1>'.$infoDemande['typeForm'].'  |  '.$infoDemande['dateTraitement']->format('d/m/y').'|  Réf. : '.$idDemandeItSelf.'</h1>';
      $response .= "<div id='propertiesDemandePrint'  class='contentBlock'><h2> Récapitulatif de la demande </h2>";

      // Boucle pour propriétés de la demande

      foreach ($properties as $idProperty => $valueProperty) {

         if (isset($properties[$idProperty])){

          $property = $properties[$idProperty];

          //Si la propriété est une date on la formate
          $prop = self::transformDate($qb[0][$property]);

          //On affiche pas les fichiers liés à la demande
          if ($prop != null) {

            if (is_array($prop)) {
              $response .= '<p><b class="col-sm-2"> '.self::getTraduction($property).'</b>  ';
              $response .= self::transformArray($prop);

            } else if (self::ifFile($prop) == true && $action =='detail') {

              // Si cest un file et qu'on est dans le résumé des demandes
              $fileList .= '<li><b class="col-sm-2">'.ucfirst($property).'</b>';
              $path = $package->getUrl($prop); //self::generateAbsUrl($prop);
              $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
            } else {
              $response .= '<p><b class="col-sm-2"> '.self::getTraduction($property).'</b>  ';
              //champs classique
              //on vérifie si c'est une valeur provenant du fichier de traduction 'translator'
              $response .= self::transformNormal($prop);
            }
          }
        } // If isset
      } // Fin for sur propriétés
    } // Fin du foreach

    $response .= '</div>';
    if ($action =='detail') {

      if (empty($fileList)) {
        $fileList = 'Aucun document disponible';
      }

      $response .= '<div id="FileList" class="contentBlock"><h2>Document(s) lié(s)</h2> <ul>';
      $response .= $fileList;
      $response .= '</ul></div>';
    }

    $response .= "<div id='infosDemandePrint' class='contentBlock'><h2> Statut de la demande </h2>";
    // Info de la demande
    // $infosDemande = $demandeRepo->infosDemande($idDemande);
    $infosSalon = $salonRepo->infosSalon($infoDemande['codeSage']);
    $statutDemande = $demandeRepo->whichStatut($infoDemande['statut']);

    $response .= '<p><b class="col-sm-2">Demandeur</b> '.$infosCollab['nom'].' '.$infosCollab['prenom'].'</p>';
    $response .= '<p><b class="col-sm-2">Date d\'envoi</b>  '.$infoDemande['dateTraitement']->format('d/m/Y').'</p>';
    $response .= '<p><b class="col-sm-2">Statut</b>  <span class="statutLabel '.$statutDemande.'">' . $statutDemande .'</span></p>';
    $response .= '<p><b class="col-sm-2">Salon</b>  '.$infosSalon['appelation'].'</p>';
    $response .= '<p><b class="col-sm-2">Adresse</b>  '.$infosSalon['adresse1'].' '.$infosSalon['codePostal'].' '.$infosSalon['ville'].'</p>';

    if ($statutDemande == "Rejeté")
      $response .= '<p><b>Motif du rejet</b>'.$infoDemande['message'].'</p>';

    $response .= '</div>';
    $response .= '</div>';


    // Document échangé pour les demandes complexes
    if ($infoDemande['complexe']) {
      $fileList ='';
      if ($infoDemande['docService']){
        $fileList .= '<li><b class="col-sm-2">Document du service</b>';
        $path = $package->getUrl($infoDemande['docService']);//self::generateAbsUrl($infoDemande['docService']);
        $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
      }

      if ($infoDemande['docSalon']) {
        $fileList .= '<li><b class="col-sm-2">Document du salon</b>';
        $path = $package->getUrl($infoDemande['docService']);//self::generateAbsUrl($infoDemande['docSalon']);
        $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
      }

      $response .= '<div id="FileList" class="contentBlock"><h2>Document(s) échangé(s)</h2> <ul>';
      $response .= $fileList;
      $response .= '</ul></div>';
    } else {
      $fileList ='';
      if ($infoDemande['docService']){
        $fileList .= '<li><b class="col-sm-2">Document du service</b>';
        $path = $package->getUrl($infoDemande['docService']);//self::generateAbsUrl($infoDemande['docService']);
        $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
      }

      $response .= '<div id="FileList" class="contentBlock"><h2>Document(s) échangé(s)</h2> <ul>';
      $response .= $fileList;
      $response .= '</ul></div>';
    }




    return $response;
  }

  public function transformDate($propriete)
  {
    if (is_object ($propriete)) {
      $prop = $propriete->format('d/m/y');
    } else {
      $prop = $propriete;
    }

    return $prop;
  }


  public function transformNormal($prop)
  {
    $response ='';

    if ( preg_match_all( '/_{3,}/', $prop, $matches, PREG_SET_ORDER, 0)) {
      $response .= $this->translator->trans($prop, array(),'translator');
    } else {

      switch ($prop) {
        case '':
          //$response .= 'n/a';
        break;

        case 'true':
          $response .= $this->translator->trans('global.affirme',array(),'translator');
        break;

        case 'false':
          $response .= $this->translator->trans('global.negative',array(),'translator');
        break;

        default:
          $response .= $prop;


      }
      $response .= '</p>';
    }
    return $response;
  }

  public function getTraduction($prop)
  {
    $trad = $this->translator
                  ->trans($this->propertyInfo->getShortDescription('AppBundle\Entity\\'. $this->nameEntity, $prop),
                                                                  array(),'translator');
    return $trad;
  }

  public function transformArray($prop)
  {
    $response = "";
    $b = 1;
    $lastItem = count($prop);

    // Cas du tableau à 2 dimensions
    if (isset($prop[0]) && is_array($prop[0]))
    {
      foreach ($prop as $keys => $values){
        foreach ($values as $key => $value){

          $value = self::transformDate($value);
          if (preg_match_all('/_{3,}/', $value, $matches, PREG_SET_ORDER, 0)) {
            $value = $this->translator->trans($value,array(),'translator');
          }

          if (is_numeric($key)) {
            $key = '';
          } else {
            $key = $key.'';
          }

          if ($b == $lastItem) {
            $response .= $key.': '.$value ;
          } else {
            $response .= $key.': '.$value.' - ';
          }
          $b++;
        }
      }

    } else {

      foreach ($prop as $key => $value){
        if (preg_match_all('/_{3,}/', $value, $matches, PREG_SET_ORDER, 0)) {
          $value = $this->translator->trans($value,array(),'translator');
        }

        if (is_numeric($key)) {
          $key = '';
        } else {
          $key = $key.'';
        }

        if ($b == $lastItem) {
          $response .= $key.': '.$value ;
        } else {
          $response .= $key.': '.$value.' - ';
        }
        $b++;
      }
    }


    $response .= '</p>';

    return $response;
  }

  //Function ifFile: test si le champs est un fichier
  //Return: retourne false si $property est un fichier
  public function ifFile($property)
  {
    $tabFiles = ['png','jpg','pdf','jpeg','bmp','doc','docx','txt', 'html', 'csv', 'tmp', 'xlsx', 'md'];
    $occ = 0;

    if (!is_array($property)) {
      foreach ($tabFiles as $tabFile ) {
        if(strpos($property, $tabFile) !== false) {
          $occ++;
        }
      }
    }

    if ($occ > 0) {
      return true;
    } else {
      return false;
    }
  }
}
