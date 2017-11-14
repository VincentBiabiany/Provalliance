<?php
//
namespace AppBundle\Repository\Admin;
use Doctrine\ORM\EntityRepository;
use ApiBundle\Entity\Personnel;

class AccountRepository extends EntityRepository
{
  //Fonction getAccountOFF : Vérifie la précense d'un personnel dans la table account

  public function ifInAccount($matricule) {

            $occ = $this->findOneBy(array('matricule' => $matricule));
            if ($occ == null){
              return false;
            }else{
              return true;
            }
    }
}
