<?php

namespace AppBundle\Repository;
use ApiBundle\Entity\Personnel;
use ApiBundle\Entity\Salon;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Entity\DemandeComplexe;
/**
 * DemandeEntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DemandeEntityRepository extends \Doctrine\ORM\EntityRepository
{
  public function filterDemande($filter, $em, $role, $idSalon, $column, $dir, $start, $length)
  {
    $isService = true;

    // Filtre des demandes pour manager/coordo et admin
    if ($role == 'ROLE_MANAGER' || $role == 'ROLE_COORD' || $role == 'ROLE_ADMIN') {
       $isService = false;
    }

    $col = array(
      "id",
      "",
      "sage",
      "enseigne",
      "appelation",
      "coordinateur",
      "manager",
      "dateTraitement",
      "statut",
      "type",
      "collaborateur",
    );
    // Récupération des filtres
    foreach ($filter as $key => $value) {
      $colFilter[] = $col[$key];
    }

    $query = $this->createQueryBuilder('d')
                  ->select('d');

    if ($role == 'ROLE_PAIE') {
      $query = $query->andWhere('d.service = :service')->setParameter('service', 'paie');
    }

    if ($role == 'ROLE_JURIDIQUE') {
      $query = $query->andWwhere('d.service = :service')->setParameter('service', 'juridique');
    }

    if (in_array("sage", $colFilter) || $isService == false)
    {
      in_array("sage", $colFilter) ? $salon = $filter[2] : $salon = $idSalon;
      $query = $query->andWhere('d.idSalon = :salon')->setParameter('salon', $salon);
    }


    if (in_array("enseigne", $colFilter) && in_array("appelation", $colFilter))
    {
      $salons = $em->createQueryBuilder('u')
                   ->select('u.sage as id')
                   ->from('ApiBundle:Salon', 'u')
                   ->leftjoin('u.enseigne', 'e')
                   ->andWhere('e.nom = :nom')
                   ->setParameter('nom', $filter[3])->getQuery()->getResult();

      foreach ($salons as $key => $value) {
        $salonsId[] = $value['id'];
      }

      $salons = $em->createQueryBuilder('u')
                   ->select('u.sage as id')
                   ->from('ApiBundle:Salon', 'u')
                   ->andWhere('u.appelation = :appelation')
                   ->setParameter('appelation', $filter[4])->getQuery()->getResult();
       foreach ($salons as $key => $value) {
             $salonsId2[] = $value['id'];
       }

       $result = array_intersect($salonsId, $salonsId2);
       $query = $query->andWhere('d.idSalon IN (:id)')->setParameter('id', $result);

    } else {
      if (in_array("enseigne", $colFilter))
      {
        $salons = $em->createQueryBuilder('u')
                     ->select('u.sage as id')
                     ->from('ApiBundle:Salon', 'u')
                     ->leftjoin('u.enseigne', 'e')
                     ->andWhere('e.nom = :nom')
                     ->setParameter('nom', $filter[3]);

        foreach ($salons as $key => $value) {
          $salonsId[] = $value['id'];
        }
        if (isset($salonsId))
          $query = $query->andWhere('d.idSalon IN (:id)')->setParameter('id', $salonsId);
      }

      if (in_array("appelation", $colFilter))
      {
        $salons = $em->createQueryBuilder('u')
                     ->select('u.sage as id')
                     ->from('ApiBundle:Salon', 'u')
                     ->where('u.appelation = :appelation')
                     ->setParameter('appelation', $filter[4]);

         foreach ($salons as $key => $value) {
               $salonsId[] = $value['id'];
         }
         if (isset($salonsId))
          $query = $query->andWhere('d.idSalon IN (:id)')->setParameter('id', $salonsId);
      }
    }

    if (in_array("coordinateur", $colFilter))
    {
      // 1 Retrouver id Personnel à partir du prenom + nom
      $idPerso = $em->createQueryBuilder('u')
                   ->select('s.sage as id')
                   ->from('ApiBundle:Personnel', 'u')
                   ->where("CONCAT(u.prenom, ' ', u.nom) = :name")
                   ->leftjoin('u.salon', 's')
                   ->setParameter('name', $filter[5])->getQuery()->getResult();
     foreach ($idPerso as $key => $value) {
        $ids[] = $value['id'];
     }
     $query = $query->andWhere('d.idSalon IN (:id)')->setParameter('id', $ids);
    }

    if (in_array("manager", $colFilter))
    {
      $idPerso = $em->createQueryBuilder('u')
                   ->select('u.matricule as id')
                   ->from('ApiBundle:Personnel', 'u')
                   ->andWhere("CONCAT(u.prenom, ' ', u.nom) = :name")
                   ->setParameter('name', $filter[6])->getQuery()->getResult();

       foreach ($idPerso as $key => $value) {
          $idP[] = $value['id'];
       }

       $query = $query->leftjoin('d.user', 'e')
                      ->andwhere('e.matricule = :id')
                      ->setParameter('id', $idP);
      }

    if (in_array("collaborateur", $colFilter))
    {
      $demandesSalon = $this->findAll();
      foreach ($demandesSalon as $key => $demande) {
        if ($demande->getDemandeform()->getTypeForm() == "Demande d'embauche") {
          if ($this->whichPersonnel($demande) == $filter[10])
            $demandeId[] = $demandeId[] =  $demande->getId();
        } else {
          $idP = $demande->getDemandeform()->getMatricule();
            if ($em->getRepository('ApiBundle:Personnel')->whichPersonnel($demande,$idP) == $filter[10])
              $demandeId[] =  $demande->getId();
        }
      }
      $query = $query->andWhere('d.id IN (:id)')->setParameter('id', $demandeId);
    }

    if (in_array("type", $colFilter))
    {
      $query = $query
                    ->leftjoin('d.demandeform', 't')
                    ->andWhere('t.typeForm = :type')
                    ->setParameter('type', $filter[9]);
    }

    if (in_array("statut", $colFilter))
    {
      if ($filter[8] == "Rejeté")
        $statut = 0;
      else if ($filter[8] == "En cours")
        $statut = 1;
      else if ($filter[8] == "Traité")
        $statut = 2;
      else if ($filter[8] == "A signer")
        $statut = 3;
      else
        $statut = 4;
      $query = $query->andWhere('d.statut = :stat')->setParameter('stat', $statut);
    }

    if (in_array("dateTraitement", $colFilter)){
      $date = new \DateTime();
      $date = $date->createFromFormat('d-m-Y', $filter[7]);

      $query = $query->andWhere("d.dateTraitement = :time")->setParameter("time", $date->format('Y-m-d'));
    }
    //dump($column, $dir);
    // return  $query->orderBy('d.'.$column, $dir)->setFirstResult( $start )->setMaxResults( $length )->getQuery()->getResult();
    return $query->getQuery()->getResult();
  }

  // Fonction getNB: Retourne le nombre de demande en fonction du service
  public function getNb($role,$idsalon) {
      if ($role =='ROLE_PAIE') {

        return $this->createQueryBuilder('d')
        ->select('COUNT(d)')
        ->where('d.service = :serviceUser')
        ->setParameter('serviceUser', 'paie')
        ->getQuery()
        ->getResult();


      } elseif ($role =='ROLE_JURIDIQUE') {
        return $this->createQueryBuilder('d')
        ->select('COUNT(d)')
        ->where('d.service = :serviceUser')
        ->setParameter('serviceUser', 'juridique')
        ->getQuery()
        ->getResult();

      } else {
        return $this->createQueryBuilder('d')
        ->select('COUNT(d)')
        ->where('d.idSalon = :salon')
        ->setParameter('salon', $idsalon)
        ->getQuery()
        ->getResult();
      }

  }

  // Fonction wichService: Retourne le tableau des demandes en fonction du service
  public function wichService($role,$typeFilter,$column,$dir,$idsalon,$search,$start,$length) {

     //Requete en bdd en fonction du type de filtre
     if (($typeFilter == 'x') or ($typeFilter == 'init') or ($typeFilter == 'search')) {

       if ($role =='ROLE_PAIE') {
         return $this->createQueryBuilder('p')
         ->where('p.service = :serviceUser')
         ->setParameter('serviceUser', 'paie')
         ->orderBy('p.dateTraitement', 'DESC')
         ->setFirstResult( $start )
         ->setMaxResults( $length )
         ->getQuery()
         ->getResult();

       } else if ($role =='ROLE_JURIDIQUE'){
         return $this->createQueryBuilder('p')
         ->where('p.service = :serviceUser')
         ->setParameter('serviceUser', 'juridique')
         ->orderBy('p.dateTraitement', 'DESC')
         ->setFirstResult( $start )
         ->setMaxResults( $length )
         ->getQuery()
         ->getResult();
       } else {
         return $this->createQueryBuilder('p')
         ->where('p.idSalon = :salon')
         ->setParameter('salon', $idsalon)
         ->orderBy('p.dateTraitement', 'DESC')
         ->setFirstResult( $start )
         ->setMaxResults( $length )
         ->getQuery()
         ->getResult();
       }
       //Affichage via filtre "normaux"
     }else if($typeFilter == 'default'){
       if ($role =='ROLE_PAIE') {
         return $this->findBy(array("service" => "paie"),
         array($column => $dir),
         $length, $start);

       } else if ($role =='ROLE_JURIDIQUE'){
         return $this->findBy(array("service" => "juridique"),
         array($column => $dir),
         $length, $start);
       } else {
         return $this->findBy(array("idSalon" => $idsalon),
         array($column => $dir),
         $length, $start);
       }
     }
  }

   // Fonction wichService: Retourne le statut de chaque demande
   public function whichStatut($demande){

     /* Statut de la demande  */
     if (is_object ($demande))
     $stat = $demande->getstatut();
     else
     $stat = $demande;

     if ($stat == 0) {
       $statut="Rejeté";

     } else if ($stat == 1) {
       $statut="En cours";

     } else if ($stat == 2) {
       $statut="Traité";

     } else if ($stat == 3) {
       $statut="A signer";

     } else if ($stat == 4) {
       $statut="A valider";
     }

     return $statut;
   }

   // Fonction whichPersonnel: Retourne nom et prenom du collaborateur pour chaque demande
   public function whichPersonnel($demande){
     $collab = $demande->getDemandeform()->getPrenom() . " " . $demande->getDemandeform()->getNom();
     return $collab;
   }

   // Fonction sortingOut: Trie le tableau des demandes par ordre Croissant ou Décroissant
   // Paramètres :
   // Return :
   public function sortingOut($typeFilter,$dir,$output,$column){
     /* TRI sur les colonnes par ordre croissant ou décroissant*/
     if ($typeFilter == 'x'){
       if($dir == "asc"){ $direction = SORT_ASC;}else { $direction = SORT_DESC; }
       foreach ($output['data'] as $key => $row) {
         $col[$key]  = $row[$column];
       }
       array_multisort($col, $direction, $output['data']);
       return $output;
     }else{
       return $output;
     }
   }

   //Fonction InfosDemande: Retourne un array avec toutes les données d'une demande
   //Paramètre : id Demande
   //Return array
   public function infosDemande($idDemande){
     $demandes=[];
     //Infos de La demande
     $requete = $this->findOneBy(array('id' => $idDemande));

     $demandes['statut'] = $requete->getStatut();
     //  $demandeStatut = self::labelStatut($statut);
     $demandes['dateTraitement'] =  $requete->getDateTraitement();
     $demandes['userID'] =  $requete->getUser();
     $demandes['codeSage'] =  $requete->getIdSalon();
     $demandes['service'] =  $requete->getService();
     $demandes['nameDemande'] = $requete->getDemandeform()->getNameDemande();
     $demandes['demandeId'] = $requete->getDemandeform()->getId();
     $demandes['typeForm'] = $requete->getDemandeform()->getTypeForm();

     return $demandes;

   }

}
