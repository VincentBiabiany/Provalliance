<?php

namespace ApiBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ApiBundle\Entity\PersonnelHasSalon;

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
   return false;}else{ return true;}

   }
}
