<?php

namespace AppBundle\Repository;

/**
 * DemandeEssaiProfessionnelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DemandeEssaiProfessionnelRepository extends \Doctrine\ORM\EntityRepository
{

  //Fonction infosDemandeSelf: Retourne un array avec toutes les infos du collab d'une demande d'embauche
  //Paramètre : id Demande
  //Return array
  public function infosDemandeSelf($idDemandeEssaiPro){
    $collaborateur=[];
    $requete = $this->findOneBy(array('id' => $idDemandeEssaiPro));

    $collaborateur['matricule']      = '0000';
    $collaborateur['nom']            = $requete->getNom();
    $collaborateur['prenom']         = $requete->getPrenom();
    $collaborateur['dateNaissance']  = $requete->getDateNaissance()->format('d-m-Y');
    $collaborateur['villeNaissance'] = $requete->getLieuNaissance();
    $collaborateur['paysNaissance']  = 'n/a';
    $collaborateur['sexe']           = 'n/a';
    $collaborateur['nationalite']    = $requete->getNationalite();
    $collaborateur['niveau']         = $requete->getNiveau();
    $collaborateur['echelon']        = 'n/a';
    $collaborateur['adresse1']       = $requete->getAdresse();
    $collaborateur['adresse2']       = 'n/a';
    $collaborateur['codePostal']     = $requete->getCodepostal();
    $collaborateur['ville' ]         = $requete->getVille();
    $collaborateur['telephone1']     = $requete->getTelephone();
    $collaborateur['telephone2']     = 'n/a';
    $collaborateur['email']          = 'n/a';

    return $collaborateur;
   }
}