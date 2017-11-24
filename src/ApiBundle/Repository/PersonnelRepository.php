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

  public function findActivePersonnelBySalon($idSalon) {

    // Met à jour les PersonnelHasSalon par rapport au date de fin
    $repo = $this->getEntityManager()->getRepository('ApiBundle:PersonnelHasSalon');

    // Retourne les id des personnels du salon qui sont actifs
    $activeP = $repo->findActivePersonnel($idSalon);

    $arrayActive = array();

    foreach ($activeP as $key => $value) {
      $arrayActive[] = $value['matricule'];
    }

    return $this->createQueryBuilder('p')
                ->join('p.personnelHasSalon', 's')
                ->where('s.salonSage = :idSalon')
                ->andWhere('p.actif = 1')
                ->andWhere('p.matricule IN (:matricule)')
                ->setParameter('matricule', $arrayActive)
                ->setParameter('idSalon', $idSalon);
  }

  public function getNb($idPerso, $idSalon) {
    $nb = $this->createQueryBuilder('d')
               ->select('COUNT(d)')
               ->join('d.personnelHasSalon', 'm')
               ->where('d.matricule = :idPerso')
               ->andwhere('m.salonSage = :idSalon')
               ->setParameter('idPerso',$idPerso)
               ->setParameter('idSalon',$idSalon)
               ->getQuery()
               ->getResult();

    return $nb[0][1];
  }

  public function findActiveSalon($idPerson)
  {
    // Met à jour les PersonnelHasSalon par rapport au date de fin
    $repo = $this->getEntityManager()->getRepository('ApiBundle:PersonnelHasSalon')->findBy(['personnelMatricule' => $idPerson]);
    $salons = array();

    foreach ($repo as $key => $persHasSalon) {
      $salons[] = $persHasSalon->getSalonSage();
    }
    return $salons;
  }


  // Fonction whichPersonnel: Retourne la liste du personnel en fonction d'un salon pour la partie ADMIN
  public function getPerso($idSalon)
  {
    $repository = $this->getEntityManager()->getRepository('ApiBundle:PersonnelHasSalon');
    $repository->findActivePersonnel();
    $listPerso = [];

    //liste des personnels non coiffeur par Salon
    $listeAccount= $repository->listPersoBySalon($idSalon);

    if ($listeAccount == null) {
      $listPerso = null;
    } else {

      foreach ($listeAccount as $key => $value) {
        $matricule = $listeAccount[$key]->getPersonnelMatricule()->getMatricule();

        $p = $this->findOneBy(array('matricule' => $matricule));
        $listPerso[$p->getNom().' '.$p->getPrenom()] = $matricule;
      }
    }

    return $listPerso;
  }

  // Fonction whichPersonnel: Retourne le nom et prenom du personnel
  // Paramètre : matricule du Personnel
  public function whichPersonnel($idP)
  {
    $collab = $this->findOneBy(array('matricule' => $idP ));

    if ($collab == null)
      $collab ='n/a';
    else
      $collab = $collab->getNom() . " " . $collab->getPrenom();

    return $collab;
  }


  // Fonction getListPerso: Retourne la liste du personnel avec la possibilité de n'effectuer aucune sélection
  // en premier lieu
  public function getListPerso($idSalon)
  {
    $listPerso['Ne concerne aucun collaborateur'] = 99999;
    $listes = $this->createQueryBuilder('d')
                   ->join('d.personnelHasSalon', 'm')
                   ->andwhere('m.salonSage = :idSalon')
                   ->setParameter('idSalon',$idSalon)
                   ->getQuery()
                   ->getResult();

    foreach ($listes as $liste) {
      $listPerso[$liste->getNom().' '.$liste->getPrenom()] = $liste->getMatricule();
    }
    return $listPerso;
  }

  // Fonction getListCollab: Retourne la liste du personnel n'ayant pas encore de compte utilisateur
  // ADMIN
  public function getListCollab($idSalon)
  {
    $collabs = $this->createQueryBuilder('d')
                    ->join('d.salon', 'm')
                    ->andwhere('m.sage = :idSalon')
                    ->setParameter('idSalon',$idSalon)
                    ->getQuery()
                    ->getResult();

    $listeAccount = [];
    foreach ($collabs as $collab) {

      $matricule = $collab->getMatricule();
      $p = $repository->findOneBy(array('matricule' => $matricule));

      if (!empty($p)) {
        $listeAccount[]= $matricule;
      }
    }
    return $listeAccount;
  }

  public function InfosCollab($idpersonnel)
  {
    $collaborateur=[];
    $requete = $this->findOneBy(array('matricule' => $idpersonnel ));

    if ($requete == null) {

      $collaborateur['matricule']      = '0000';
      $collaborateur['nom']            = 'Admin';
      $collaborateur['prenom']         = '';
      $collaborateur['dateNaissance']  = 'n/a';
      $collaborateur['villeNaissance'] = 'n/a';
      $collaborateur['paysNaissance']  = 'n/a';
      $collaborateur['dateNaissance']  = 'n/a';
      $collaborateur['sexe']           = 'n/a';
      $collaborateur['nationalite']    = 'n/a';
      $collaborateur['niveau']         = 'n/a';
      $collaborateur['echelon']        = 'n/a';
      $collaborateur['adresse1']       = 'n/a';
      $collaborateur['adresse2']       = 'n/a';
      $collaborateur['codePostal']     = 'n/a';
      $collaborateur['ville']          = 'n/a';
      $collaborateur['telephone']     = 'n/a';
      $collaborateur['email']          = 'n/a';
      $collaborateur['dateEntree']     = 'n/a';
      $collaborateur['dateSortie']     = 'n/a';

    } else {

      $collaborateur['matricule']      = $requete->getMatricule();
      $collaborateur['nom']            = $requete->getNom();
      $collaborateur['prenom']         = $requete->getPrenom();
      $collaborateur['dateNaissance']  = $requete->getDateNaissance()->format('d/m/Y');
      $collaborateur['villeNaissance'] = $requete->getVilleNaissance();
      $collaborateur['paysNaissance']  = $requete->getPaysNaissance();
      $collaborateur['dateNaissance']  = $requete->getDateNaissance()->format('d/m/Y');
      $collaborateur['sexe']           = $requete->getSexe();
      $collaborateur['nationalite']    = $requete->getNationalite();
      $collaborateur['niveau']         = $requete->getNiveau();
      $collaborateur['echelon']        = $requete->getEchelon();
      $collaborateur['adresse1']       = $requete->getAdresse1();
      $collaborateur['adresse2']       = $requete->getAdresse2();
      $collaborateur['codePostal']     = $requete->getCodepostal();
      $collaborateur['ville']          = $requete->getVille();
      $collaborateur['telephone']      = $requete->getTelephone();
      $collaborateur['email']          = $requete->getEmail();
      $collaborateur['dateEntree']     = $requete->getDateEntree()->format('d/m/Y');

      if($requete->getDateSortie()!= null){
          $collaborateur['dateSortie']     = $requete->getDateSortie()->format('d/m/Y');
        }else{
          $collaborateur['dateSortie']     = 'n/a';
        }
    }

    return $collaborateur;
  }
}
