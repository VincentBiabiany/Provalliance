<?php

namespace AppBundle\Repository;

/**
 * DemandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DemandeRepository extends \Doctrine\ORM\EntityRepository
{

  public function getNb($role,$idsalon) {
      if ($role =='ROLE_PAIE') {

        return $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.service = :serviceUser')
            ->setParameter('serviceUser', 'paie')
            ->getQuery()
            ->getResult();


      }elseif ($role =='ROLE_JURIDIQUE') {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.service = :serviceUser')
            ->setParameter('serviceUser', 'juridique')
            ->getQuery()
            ->getResult();

      }else {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.idSalon = :salon')
            ->setParameter('salon', $idsalon)
            ->getQuery()
            ->getResult();
        }
   }

}
