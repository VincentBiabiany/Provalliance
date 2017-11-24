<?php
namespace AppBundle\Service\Util;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Doctrine\ORM\EntityManager;
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

class FormatProprieteService
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
      }
      return $response;
    }

    public function getTraduction($prop , $nameEntity, $infoProperty)
    {
      $trad = $this->translator
                    ->trans($infoProperty->getShortDescription('AppBundle\Entity\\'.$nameEntity, $prop),
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

    //Fonction whichCol: Retourne les noms des différentes propriétés d'une entity et leur nombre
    //Paramètre : Entity Name
    //Return array
    public function whichCol($nameEntity){
        $reflectionExtractor = new ReflectionExtractor();
        $listExtractors = $reflectionExtractor;
        $propertyInfo = new PropertyInfoExtractor(array( $listExtractors ));

        $properties = $propertyInfo->getProperties('AppBundle\Entity\\'.$nameEntity);
        $properties = array_diff($properties,['discr','typeForm','id','nameDemande','service','subject','nomDoc']);

        return $properties;

    }

    //Fonction whichVal: Retourne les noms des différentes propriétés d'une entity et leur nombre
    //Paramètre : Entity Name, Id Demande , Property Name
    //Return string
    public function whichVal($nameEntity,$idDemande,$nameProperty){
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
