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

class ResumeDemandeService
{
  private $em;
  private $em2;
  private $translator;


  public function __construct(EntityManager $em, EntityManager $em2, Translator $translator)
  {
    $this->em           = $em;
    $this->em2          = $em2;
    $this->translator   = $translator;

  }

  public function generateResume($idDemandes,$action)
  {
    //Extrator Properties
    $reflectionExtractor = new ReflectionExtractor();
    $listExtractors = $reflectionExtractor;
    $propertyInfo = new PropertyInfoExtractor(array( $listExtractors ));
    //Repository
    $demandeRepo = $this->em2->getRepository('AppBundle:DemandeEntity');
    $salonRepo = $this->em->getRepository('ApiBundle:Salon');
    $persoRepo = $this->em->getRepository('ApiBundle:Personnel');

    //Var For HTML
      $response = '';
      $fileList = '';

    //Path
    $package = new PathPackage('web/uploads/files', new EmptyVersionStrategy());

    //1 demande par page
    foreach ($idDemandes as $idDemande ) {
      $response .= '<div class="page">';
      $infoDemande = $demandeRepo->infosDemande($idDemande);
      $infosCollab = $persoRepo->InfosCollab($infoDemande['userID']);

      $nameEntity = $infoDemande['nameDemande'];
      $idDemandeItSelf = $infoDemande['demandeId'];

      $properties = $propertyInfo->getProperties('AppBundle\Entity\\'.$nameEntity);
      $properties = array_diff($properties,['discr','typeForm','id','nameDemande','subject','service']);
      $response .= '<h1>'.$infoDemande['typeForm'].'  |  '.$infoDemande['dateTraitement']->format('d/m/y').'
        |  Réf. : '.$idDemandeItSelf.'</h1>';

      $response .= "<div id='propertiesDemandePrint'  class='contentBlock'><h2> Récapitulatif de la demande </h2>";
          // Boucle pour propriétés de la demande
          for ($k = 0; $k < count($properties); $k++) {
            if (isset($properties[$k])){
            $property = $properties[$k];

            $qb = $this->em2->createQueryBuilder()
                            ->add('select', 'u')
                            ->add('from', 'AppBundle:'.$nameEntity.' u')
                            ->add('where', 'u.id = :idDemande')
                            ->setParameter('idDemande', $idDemandeItSelf)
                            ->getQuery()
                            ->getArrayResult();
                            //Si la propriété est une date on la formate
                            if ( is_object ($qb[0][$property])){
                              $prop = $qb[0][$property]->format('d-m-y');

                            } else{
                              $prop = $qb[0][$property];
                            }

                            //On affiche pas les fichiers liés à la demande
                            if( self::ifFile($prop) == false ){
                              $response .= '<p><b>'.ucfirst($property).'</b>  ';

                                if( is_array($prop)){
                                  //champs de type array
                                  $b=1;
                                  $lastItem=count($prop);
                                 foreach ($prop as $key => $value){
                                   // dump($prop);
                                   // frsdf();
                                   $re = '/_{3,}/';
                                   if( preg_match_all($re, $value, $matches, PREG_SET_ORDER, 0)){
                                    $value = $this->translator->trans($value,array(),'translator','fr_FR');
                                      }
                                      if( is_numeric($key)){
                                        $key = '';
                                      }else{
                                        $key = $key.'';
                                      }
                                          if($b == $lastItem){
                                             $response .= $key.': '.$value;
                                           }else{
                                             $response .= $key.': '.$value.' - ';

                                           }

                                        $b++;
                                    }
                                     $response .= '</p>';
                                }else{
                                  //champs classique
                                  //on vérifie si c'est une valeur provenant du fichier de traduction 'translator'
                                  $re = '/_{3,}/';
                                 if( preg_match_all($re, $prop, $matches, PREG_SET_ORDER, 0)){
                                  $response .= $this->translator->trans($prop,array(),'translator','fr_FR');

                                    } else{
                                      switch ($prop) {
                                          case '':
                                              $response .= 'n/a';
                                              break;
                                          case 'true':
                                              $response .= $this->translator->trans('global.affirme',array(),'translator','fr_FR');
                                              break;
                                          case 'false':
                                              $response .= $this->translator->trans('global.negative',array(),'translator','fr_FR');

                                              break;
                                          default:
                                           $response .= $prop;
                                      }


                                    }
                                  $response .= '</p>';

                                }
                            }else{
                              if ($action =='detail'){
                              $fileList .= '<li><b>'.ucfirst($property).'</b>';
                              $path = $package->getUrl($prop);
                              $fileList .= '<a class="downloadFile" href="'.$path.'">Télécharger le document</a></li>';
                             }
                          }
                }
          }

          $response .= '</div>';
          if ($action =='detail'){

              if(empty($fileList)  ){
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

            $response .= '<p><b>Demandeur</b> : '.$infosCollab['nom'].' '.$infosCollab['prenom'].'</p>';
            $response .= '<p><b>Date d\'envoi</b> : '.$infoDemande['dateTraitement']->format('d/m/Y').'</p>';
            $response .= '<p><b>Statut</b> : <span class="'.$statutDemande.'">' . $statutDemande .'</span></p>';
            $response .= '<p><b>Salon</b> : '.$infosSalon['appelation'].'</p>';
            $response .= '<p><b>Adresse</b> : '.$infosSalon['adresse1'].' '.$infosSalon['codePostal'].' '.$infosSalon['ville'].'</p>';

            if ($statutDemande == "Rejeté")
              $response .= '<p><b>Motif du rejet</b> : '.$infoDemande['message'].'</p>';

            $response .= '</div>';
      $response .= '</div>';

   }
   return $response;

 }

    //Function ifFile: test si le champs est un fichier
    //Return: retourne false si $property est un fichier
   public function ifFile($property){
      $tabFiles= ['png','jpg','pdf','jpeg','bmp','doc','docx','txt'];
      $occ=0;

      if(!is_array($property)){
          foreach ($tabFiles as $tabFile ) {

                     if(strpos($property, $tabFile) !== false){
                        $occ++;
                     }
          }
        }
      if ( $occ > 0){
        return true;
      }else{
        return false;
      }
  }
}
