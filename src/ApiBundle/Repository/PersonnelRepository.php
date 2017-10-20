<?php

namespace ApiBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ApiBundle\Entity\Personnel;

/**
 * PersonnelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonnelRepository extends EntityRepository
{
    public function getNb($idPerso,$idSalon) {
          $nb = $this->createQueryBuilder('d')
              ->select('COUNT(d)')
              ->join('d.salon', 'm')
              ->where('d.matricule = :idPerso')
              ->andwhere('m.sage = :idSalon')
              ->setParameter('idPerso',$idPerso)
              ->setParameter('idSalon',$idSalon)
              ->getQuery()
              ->getResult();

            return $nb[0][1];
      }

   // Fonction whichPersonnel: Retourne la liste du personnel en fonction d'un salon pour la partie ADMIN
    public function getPerso($listeAccount,$idSalon){
        $personnel = new Personnel();
        $listPerso=[];
        if ($listeAccount == null) {
            $listPerso['Aucun utilisateur disponible']= null ;
        }else{
        foreach ($listeAccount as $key => $value) {
                if ( self::getNb($value,$idSalon) > 0 ){
                     $p = $this->findOneBy(array('matricule' => $value));
                     $listPerso[$p->getNom().' '.$p->getPrenom()] = $value;
            }
         }
            if(empty($listPerso)){
              $listPerso['Aucun utilisateur disponible']= null ;
            }
        return $listPerso;
     }
   }

   // Fonction whichPersonnel: Retourne les infos du personnel pour chaque demande dans partie Suivi des Demandes
   public function whichPersonnel($demande, $idP){

          $collab = $this->findOneBy(array('matricule' => $idP ));
          $collab = $collab->getNom() . " " . $collab->getPrenom();

      return $collab;
   }

}
