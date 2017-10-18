<?php
//
namespace AppBundle\Repository\Admin;
use Doctrine\ORM\EntityRepository;
use ApiBundle\Entity\Personnel;

class AccountRepository extends EntityRepository
{
  //Fonction getAccountOFF : Récupere tout le personnel n'ayant pas encore de compte utilisateur

  public function getAccountOff($idsalon) {
        $qb = $this->createQueryBuilder('p');
        $listes = $qb->select('p')
                  ->where("p.etat = :etat")
                  ->setParameter('etat', 0)
                  ->getQuery()
                  ->getResult();
        $listeAccount=[];
            if (count($listes ) == 0) {
                $listeAccount=null;
            }else{
                foreach ($listes as $liste ) {
                    $listeAccount[]= $liste->getIdPersonnel();
                }
            }
             return $listeAccount;

    }


}
