<?php
namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\TranslatorInterface;
use Doctrine\ORM\EntityManager;
use ApiBundle\Entity\Personnel;
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

class ImpressionService
{
  private $em;
  private $em2;

  public function __construct(EntityManager $em, EntityManager $em2)
  {
    $this->em           = $em;
    $this->em2          = $em2;
  }

  public function printGenerate($idDemandes)
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
    //1 demande par page
    foreach ($idDemandes as $idDemande ) {
      $response .= '<div class="page">';

      $infoDemande = $demandeRepo->infosDemande($idDemande);
      $infosCollab = $persoRepo->InfosCollab($infoDemande['userID']);

      $nameEntity = $infoDemande['nameDemande'];
      $idDemandeItSelf = $infoDemande['demandeId'];

      $properties = $propertyInfo->getProperties('AppBundle\Entity\\'.$nameEntity);
      $properties = array_diff($properties,['discr','typeForm','id','nameDemande']);
      $response .= '<h1>'.$infoDemande['typeForm'].' | '.$infoDemande['dateTraitement']->format('d-m-y').'
       | Matricule : '.$infosCollab['matricule'].'</h1>';

      $response .= '<div id="propertiesDemandePrint"><h2> Récapitulatif de la demande </h2>';
          // Boucle pour propriétés de la demande
          for ($k = 0; $k < count($properties); $k++) {

            $property = $properties[$k];
            $qb = $this->em2->createQueryBuilder()
                            ->add('select', 'u')
                            ->add('from', 'AppBundle:'.$nameEntity.' u')
                            ->add('where', 'u.id = :idDemande')
                            ->setParameter('idDemande', $idDemandeItSelf)
                            ->getQuery()
                            ->getArrayResult();
                            $response .= '<p><b>'.$property.'</b> : ';
                            if ( is_object ($qb[0][$property])){
                              $prop = $qb[0][$property]->format('d-m-y');

                            } else{
                              $prop = $qb[0][$property];
                            }
                            $response .= $prop.'</p>';
          }
          $response .= '</div>';

            $response .= "<div id='infosDemandePrint'><h2> Statut de la demande </h2>";
            // Info de la demande
            // $infosDemande = $demandeRepo->infosDemande($idDemande);
            $infosSalon = $salonRepo->infosSalon($infoDemande['codeSage']);
            $statutDemande = $demandeRepo->whichStatut($infoDemande['statut']);

            $response .= '<p><b>Demandeur</b> : '.$infosCollab['nom'].' '.$infosCollab['prenom'].'</p>';
            $response .= '<p><b>Date d\'envoi</b> : '.$infoDemande['dateTraitement']->format('d-m-Y').'</p>';
            $response .= '<p><b>Statut</b> : '.$statutDemande.'</p>';
            $response .= '<p><b>Salon</b> : '.$infosSalon['appelation'].'</p>';
            $response .= '<p><b>Adresse</b> : '.$infosSalon['adresse1'].' '.$infosSalon['codePostal'].' '.$infosSalon['ville'].'</p>';
            $response .= '</div>';
      $response .= '</div>';

   }
   return $response;

 }
}
