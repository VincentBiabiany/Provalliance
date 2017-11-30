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
use AppBundle\Service\Util\FormatProprieteService;

class ResumeDemandeService
{
  private $em;
  private $em2;
  private $translator;
  private $propertyInfo;
  private $nameEntity;
  private $router;
  private $formatPropriete;

  public function __construct(EntityManager $em, EntityManager $em2, Translator $translator, Router $router, FormatProprieteService $formatPropriete)
  {
    $this->em           = $em;
    $this->em2          = $em2;
    $this->translator   = $translator;
    $this->router       = $router;
    $this->formatPropriete = $formatPropriete;

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
      $response .= '<h1>'.$infoDemande['typeForm'].'  |  '.$infoDemande['dateTraitement']->format('d/m/y').' |  Réf. : '.$idDemandeItSelf.'</h1>';
      $response .= "<div id='propertiesDemandePrint'  class='contentBlock'><h2> Récapitulatif de la demande </h2>";

      // Boucle pour propriétés de la demande

      foreach ($properties as $idProperty => $valueProperty) {
          //Si la propriété est une date on la formate
          $prop = $this->formatPropriete->transformDate($qb[0][$valueProperty]);

          //On affiche pas les fichiers liés à la demande
          if ($prop != null) {

            if (is_array($prop)) {

              $response .= '<p><b class="col-sm-3"> '.$this->formatPropriete->getTraduction($valueProperty, $this->nameEntity, $this->propertyInfo).'</b>  ';
              $response .= $this->formatPropriete->transformArray($prop, $this->nameEntity, $this->propertyInfo);
              $response .= '</p>';

            } else if ($this->formatPropriete->ifFile($prop) == true && $action =='detail') {

              // Si cest un file et qu'on est dans le résumé des demandes
              $fileList .= '<li><b class="col-sm-3">'.ucfirst($valueProperty).'</b>';
              $path = $package->getUrl($prop); //$this->formatPropriete->generateAbsUrl($prop);
              $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';

            } else {

              $response .= '<p><b class="col-sm-3"> '.$this->formatPropriete->getTraduction($valueProperty, $this->nameEntity, $this->propertyInfo).'</b>  ';
              //champs classique
              //on vérifie si c'est une valeur provenant du fichier de traduction 'translator'
              $response .= $this->formatPropriete->transformNormal($prop);
              $response .= '</p>';

              //On récupère le nom et le prenom du collaborateur visé par la demande
              if ($valueProperty == 'matricule'){
                $response .= '<p><b class="col-sm-3">Collaborateur</b>  ';
                $response .= $persoRepo->whichPersonnel($prop);
                $response .= '</p>';
                $response .= '<p><b class="col-sm-3">Adresse</b>  ';
                $response .= $persoRepo->whichAdresse($prop);
                $response .= '</p>';
              }

            }
          }
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

    $response .= "<div id='infosDemandePrint' class='contentBlock'> <h2> Statut de la demande </h2>";
    // Info de la demande
    // $infosDemande = $demandeRepo->infosDemande($idDemande);
    $infosSalon = $salonRepo->infosSalon($infoDemande['codeSage']);
    $statutDemande = $demandeRepo->whichStatut($infoDemande['statut']);

    $response .= '<p><b class="col-sm-3">Demandeur</b> '.$infosCollab['nom'].' '.$infosCollab['prenom'].'</p>';
    $response .= '<p><b class="col-sm-3">Date d\'envoi</b>  '.$infoDemande['dateTraitement']->format('d/m/Y').'</p>';
    $response .= '<p><b class="col-sm-3">Statut</b>  <span class="statutLabel '.str_replace(' ','_',$statutDemande).'">' . $statutDemande .'</span></p>';
    $response .= '<p><b class="col-sm-3">Salon</b>  '.$infosSalon['appelation'].'</p>';
    $response .= '<p><b class="col-sm-3">Adresse</b>  '.$infosSalon['adresse1'].' '.$infosSalon['codePostal'].' '.$infosSalon['ville'].'</p>';

    if ($statutDemande == "Rejeté")
      $response .= '<p><b>Motif du rejet</b>'.$infoDemande['message'].'</p>';

    $response .= '</div>';


    // Document échangé pour les demandes complexes
    if ($infoDemande['complexe']) {
      $fileList ='';
      if ($infoDemande['docService']){
        $fileList .= '<li><b class="col-sm-3">Document du service</b>';
        $path = $package->getUrl($infoDemande['docService']);//self::generateAbsUrl($infoDemande['docService']);
        $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
      }

      if ($infoDemande['docSalon']) {
        $fileList .= '<li><b class="col-sm-3">Document du salon</b>';
        $path = $package->getUrl($infoDemande['docService']);//self::generateAbsUrl($infoDemande['docSalon']);
        $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
      }

      $response .= '<div id="FileList" class="contentBlock"><h2>Document(s) échangé(s)</h2> <ul>';
      $response .= $fileList;
      $response .= '</ul></div>';
    } else {
      $fileList ='';
      if ($infoDemande['docService']){
        $fileList .= '<li><b class="col-sm-3">Document du service</b>';
        $path = $package->getUrl($infoDemande['docService']);//self::generateAbsUrl($infoDemande['docService']);
        $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
      }

      $response .= '<div id="FileList" class="contentBlock"><h2>Document(s) échangé(s)</h2> <ul>';
      $response .= $fileList;
      $response .= '</ul></div>';
    }

    $response .= '</div>';



    return $response;
  }
}
