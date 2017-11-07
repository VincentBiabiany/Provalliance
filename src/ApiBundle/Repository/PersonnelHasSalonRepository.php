<?php

namespace ApiBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ApiBundle\Entity\PersonnelHasSalon;
use ApiBundle\Entity\Personnel;
/**
 * PersonnelHasSalonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonnelHasSalonRepository extends EntityRepository
{
  public function ifCoiffeur($idPerso){
    $p= $this->findOneBy(array('personnelMatricule' => $idPerso, 'profession' => 3));

    if (empty($p)){
      return true;}else{ return false;}
    }

  public function findActivePersonnel()
  {
    // Permet de checker la date de fin par rapport à la date d'aujourd'hui
    // Voir onPostLoad de l'entity PersonnelHasSalon

    $pers = $this->findAll();
    $this->getEntityManager()->flush();

     $active = $this->createQueryBuilder('ps')
                    ->select('p.matricule')
                    ->leftjoin('ps.personnelMatricule', 'p')
                    ->where('ps.actif = 1')->getQuery()->getResult();
    return $active;
  }

}
