<?php
//
namespace AppBundle\Repository\Admin;
use Doctrine\ORM\EntityRepository;
use ApiBundle\Entity\User;

class UserRepository extends EntityRepository
{
  //Fonction getAccountOFF : Récupere tout le personnel n'ayant pas encore de compte utilisateur

  public function uniqueField($inputUsername) {
      $nb = $this->createQueryBuilder('d')
          ->select('COUNT(d)')
          ->where('d.usernameCanonical like :inputUsername')
          ->setParameter('inputUsername',$inputUsername)
          ->getQuery()
          ->getResult();

        return $nb[0][1];

    }

    public function getlabelRole($role) {

      switch ($role) {
          case 'ROLE_MANAGER':
          $labelRole = 'Manager';
              break;
          case 'ROLE_COORD':
          $labelRole= 'Coordinateur';
              break;
          case 'ROLE_PAIE':
          $labelRole= 'Service Paie';
              break;
          case 'ROLE_JURIDIQUE':
          $labelRole= 'Service Juridique';
              break;
      }
      return $labelRole;
  }
}
