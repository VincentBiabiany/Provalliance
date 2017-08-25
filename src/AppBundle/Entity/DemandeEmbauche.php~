<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeEmbauche
 *
 * @ORM\Table(name="webapp.demande_embauche")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeEmbaucheRepository")
 */
class DemandeEmbauche
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="addresse_1", type="string", length=255)
     */
    private $addresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="addresse_2", type="string", length=255, nullable=true)
     */
    private $addresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=255)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="telephone", type="integer")
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="num_secu", type="integer")
     */
    private $numSecu;

    /**
     * @var string
     *
     * @ORM\Column(name="date_naissance", type="string", length=255)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_naissance", type="string", length=255)
     */
    private $villeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_enfant", type="integer")
     */
    private $nbEnfant;

    /**
     * @var string
     *
     * @ORM\Column(name="date_embauche", type="string", length=255)
     */
    private $dateEmbauche;

    /**
     * @var string
     *
     * @ORM\Column(name="deja_salarie", type="string", length=255)
     */
    private $dejaSalarie;

    /**
     * @var string
     *
     * @ORM\Column(name="salarie_lieu", type="string", length=255)
     */
    private $salarieLieu;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=255)
     */
    private $poste;

    /**
     * @var array
     *
     * @ORM\Column(name="diplomes", type="array")
     */
    private $diplomes;

    /**
     * @var string
     *
     * @ORM\Column(name="classification", type="string", length=255)
     */
    private $classification;

    /**
     * @var string
     *
     * @ORM\Column(name="echelon", type="string", length=255)
     */
    private $echelon;

    /**
     * @var string
     *
     * @ORM\Column(name="autre", type="string", length=255)
     */
    private $autre;

    /**
     * @var string
     *
     * @ORM\Column(name="salaire_base", type="string", length=255)
     */
    private $salaireBase;

    /**
     * @var string
     *
     * @ORM\Column(name="type_contrat", type="string", length=255)
     */
    private $typeContrat;

    /**
     * @var string
     *
     * @ORM\Column(name="surcroit_activite", type="string", length=255)
     */
    private $surcroitActivite;

    /**
     * @var string
     *
     * @ORM\Column(name="remplacement_nature", type="string", length=255)
     */
    private $remplacementNature;

    /**
     * @var string
     *
     * @ORM\Column(name="remplacement_date", type="string", length=255)
     */
    private $remplacementDate;

    /**
     * @var string
     *
     * @ORM\Column(name="remplacement_nom", type="string", length=255)
     */
    private $remplacementNom;

    /**
     * @var string
     *
     * @ORM\Column(name="remplacement_date2", type="string", length=255)
     */
    private $remplacementDate2;

    /**
     * @var string
     *
     * @ORM\Column(name="renouvellement", type="string", length=255)
     */
    private $renouvellement;

    /**
     * @var array
     *
     * @ORM\Column(name="temps_partiel", type="array")
     */
    private $tempsPartiel;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return DemandeEmbauche
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set addresse1
     *
     * @param string $addresse1
     *
     * @return DemandeEmbauche
     */
    public function setAddresse1($addresse1)
    {
        $this->addresse1 = $addresse1;

        return $this;
    }

    /**
     * Get addresse1
     *
     * @return string
     */
    public function getAddresse1()
    {
        return $this->addresse1;
    }

    /**
     * Set addresse2
     *
     * @param string $addresse2
     *
     * @return DemandeEmbauche
     */
    public function setAddresse2($addresse2)
    {
        $this->addresse2 = $addresse2;

        return $this;
    }

    /**
     * Get addresse2
     *
     * @return string
     */
    public function getAddresse2()
    {
        return $this->addresse2;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return DemandeEmbauche
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return DemandeEmbauche
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return DemandeEmbauche
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return DemandeEmbauche
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set numSecu
     *
     * @param integer $numSecu
     *
     * @return DemandeEmbauche
     */
    public function setNumSecu($numSecu)
    {
        $this->numSecu = $numSecu;

        return $this;
    }

    /**
     * Get numSecu
     *
     * @return int
     */
    public function getNumSecu()
    {
        return $this->numSecu;
    }

    /**
     * Set dateNaissance
     *
     * @param string $dateNaissance
     *
     * @return DemandeEmbauche
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return string
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set villeNaissance
     *
     * @param string $villeNaissance
     *
     * @return DemandeEmbauche
     */
    public function setVilleNaissance($villeNaissance)
    {
        $this->villeNaissance = $villeNaissance;

        return $this;
    }

    /**
     * Get villeNaissance
     *
     * @return string
     */
    public function getVilleNaissance()
    {
        return $this->villeNaissance;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return DemandeEmbauche
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set nbEnfant
     *
     * @param integer $nbEnfant
     *
     * @return DemandeEmbauche
     */
    public function setNbEnfant($nbEnfant)
    {
        $this->nbEnfant = $nbEnfant;

        return $this;
    }

    /**
     * Get nbEnfant
     *
     * @return int
     */
    public function getNbEnfant()
    {
        return $this->nbEnfant;
    }

    /**
     * Set dateEmbauche
     *
     * @param string $dateEmbauche
     *
     * @return DemandeEmbauche
     */
    public function setDateEmbauche($dateEmbauche)
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * Get dateEmbauche
     *
     * @return string
     */
    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }

    /**
     * Set dejaSalarie
     *
     * @param string $dejaSalarie
     *
     * @return DemandeEmbauche
     */
    public function setDejaSalarie($dejaSalarie)
    {
        $this->dejaSalarie = $dejaSalarie;

        return $this;
    }

    /**
     * Get dejaSalarie
     *
     * @return string
     */
    public function getDejaSalarie()
    {
        return $this->dejaSalarie;
    }

    /**
     * Set salarieLieu
     *
     * @param string $salarieLieu
     *
     * @return DemandeEmbauche
     */
    public function setSalarieLieu($salarieLieu)
    {
        $this->salarieLieu = $salarieLieu;

        return $this;
    }

    /**
     * Get salarieLieu
     *
     * @return string
     */
    public function getSalarieLieu()
    {
        return $this->salarieLieu;
    }

    /**
     * Set poste
     *
     * @param string $poste
     *
     * @return DemandeEmbauche
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set diplomes
     *
     * @param array $diplomes
     *
     * @return DemandeEmbauche
     */
    public function setDiplomes($diplomes)
    {
        $this->diplomes = $diplomes;

        return $this;
    }

    /**
     * Get diplomes
     *
     * @return array
     */
    public function getDiplomes()
    {
        return $this->diplomes;
    }

    /**
     * Set classification
     *
     * @param string $classification
     *
     * @return DemandeEmbauche
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return string
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Set echelon
     *
     * @param string $echelon
     *
     * @return DemandeEmbauche
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;

        return $this;
    }

    /**
     * Get echelon
     *
     * @return string
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    /**
     * Set autre
     *
     * @param string $autre
     *
     * @return DemandeEmbauche
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;

        return $this;
    }

    /**
     * Get autre
     *
     * @return string
     */
    public function getAutre()
    {
        return $this->autre;
    }

    /**
     * Set salaireBase
     *
     * @param string $salaireBase
     *
     * @return DemandeEmbauche
     */
    public function setSalaireBase($salaireBase)
    {
        $this->salaireBase = $salaireBase;

        return $this;
    }

    /**
     * Get salaireBase
     *
     * @return string
     */
    public function getSalaireBase()
    {
        return $this->salaireBase;
    }

    /**
     * Set typeContrat
     *
     * @param string $typeContrat
     *
     * @return DemandeEmbauche
     */
    public function setTypeContrat($typeContrat)
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    /**
     * Get typeContrat
     *
     * @return string
     */
    public function getTypeContrat()
    {
        return $this->typeContrat;
    }

    /**
     * Set surcroitActivite
     *
     * @param string $surcroitActivite
     *
     * @return DemandeEmbauche
     */
    public function setSurcroitActivite($surcroitActivite)
    {
        $this->surcroitActivite = $surcroitActivite;

        return $this;
    }

    /**
     * Get surcroitActivite
     *
     * @return string
     */
    public function getSurcroitActivite()
    {
        return $this->surcroitActivite;
    }

    /**
     * Set remplacementNature
     *
     * @param string $remplacementNature
     *
     * @return DemandeEmbauche
     */
    public function setRemplacementNature($remplacementNature)
    {
        $this->remplacementNature = $remplacementNature;

        return $this;
    }

    /**
     * Get remplacementNature
     *
     * @return string
     */
    public function getRemplacementNature()
    {
        return $this->remplacementNature;
    }

    /**
     * Set remplacementDate
     *
     * @param string $remplacementDate
     *
     * @return DemandeEmbauche
     */
    public function setRemplacementDate($remplacementDate)
    {
        $this->remplacementDate = $remplacementDate;

        return $this;
    }

    /**
     * Get remplacementDate
     *
     * @return string
     */
    public function getRemplacementDate()
    {
        return $this->remplacementDate;
    }

    /**
     * Set remplacementNom
     *
     * @param string $remplacementNom
     *
     * @return DemandeEmbauche
     */
    public function setRemplacementNom($remplacementNom)
    {
        $this->remplacementNom = $remplacementNom;

        return $this;
    }

    /**
     * Get remplacementNom
     *
     * @return string
     */
    public function getRemplacementNom()
    {
        return $this->remplacementNom;
    }

    /**
     * Set remplacementDate2
     *
     * @param string $remplacementDate2
     *
     * @return DemandeEmbauche
     */
    public function setRemplacementDate2($remplacementDate2)
    {
        $this->remplacementDate2 = $remplacementDate2;

        return $this;
    }

    /**
     * Get remplacementDate2
     *
     * @return string
     */
    public function getRemplacementDate2()
    {
        return $this->remplacementDate2;
    }

    /**
     * Set renouvellement
     *
     * @param string $renouvellement
     *
     * @return DemandeEmbauche
     */
    public function setRenouvellement($renouvellement)
    {
        $this->renouvellement = $renouvellement;

        return $this;
    }

    /**
     * Get renouvellement
     *
     * @return string
     */
    public function getRenouvellement()
    {
        return $this->renouvellement;
    }

    /**
     * Set tempsPartiel
     *
     * @param array $tempsPartiel
     *
     * @return DemandeEmbauche
     */
    public function setTempsPartiel($tempsPartiel)
    {
        $this->tempsPartiel = $tempsPartiel;

        return $this;
    }

    /**
     * Get tempsPartiel
     *
     * @return array
     */
    public function getTempsPartiel()
    {
        return $this->tempsPartiel;
    }
}
