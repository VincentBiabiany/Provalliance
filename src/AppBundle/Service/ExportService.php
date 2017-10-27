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

class ExportService
{
  // private $em;
  // private $dir;
  // private $trans;
  //
  // public function __construct(EntityManager $em, TranslatorInterface $trans, $dir)
  // {
  //   $this->em     = $em;
  //   $this->dir    = $dir;
  //   $this->trans  = $trans;
  // }

  public function importPersonnel()
  {

  }

}
