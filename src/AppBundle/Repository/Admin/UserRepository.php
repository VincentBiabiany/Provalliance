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


}
