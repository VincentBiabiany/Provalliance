<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandeEssaiProfessionnel
 *
 * @ORM\Table(name="demande_essai_professionnel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeEssaiProfessionnelRepository")
 */
class DemandeEssaiProfessionnel extends DemandeForm
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
     * ___demande_essai_pro.nom
     *
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
     * ___demande_essai_pro.prenom
     *
     * @var string
     *
     * @ORM\Column(name="prenom", type="string")
     */
    private $prenom;

    /**
     * ___demande_essai_pro.adresse
     *
     * @var string
     *
     * @ORM\Column(name="adresse", type="string")
     */
    private $adresse;

    /**
     * ___demande_essai_pro.codePostal
     *
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string")
     */
    private $codePostal;

    /**
     * ___demande_essai_pro.ville
     *
     * @var string
     *
     * @ORM\Column(name="ville", type="string")
     */
    private $ville;

    /**
     * ___demande_essai_pro.dateNaissance
     *
     * @var string
     *
     * @ORM\Column(name="date_naissance", type="date", length=255)
     */
    private $dateNaissance;

    /**
     * ___demande_essai_pro.nationalite
     *
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string")
     */
    private $nationalite;

    /**
     * ___demande_essai_pro.lieuNaissance
     *
     * @var string
     *
     * @ORM\Column(name="lieu_naissance", type="string")
     */
    private $lieuNaissance;

    /**
     * ___demande_essai_pro.departement
     *
     * @var string
     *
     * @ORM\Column(name="departement", type="string")
     */
    private $departement;


    /**
     * ___demande_essai_pro.numSecu
     *
     * @var string
     *
     * @ORM\Column(name="num_secu", type="string", length=255)
     */
    private $numSecu;

    /**
     * ___demande_essai_pro.dateEssai
     *
    * @var string
    *
    * @ORM\Column(name="date_essai", type="date", length=255)
    */
    private $dateEssai;

    /**
     * ___demande_essai_pro.niveau
     *
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255,  nullable=true)
     */
    private $niveau;

    /**
     * ___demande_essai_pro.diplomes
     *
     * @var array
     *
     * @ORM\Column(name="diplomes", type="array")
     */
    private $diplomes;

    /**
     * ___demande_essai_pro.qualification
     *
     * @var string
     *
     * @ORM\Column(name="qualification", type="string")
     */

    private $qualification;

    /**
     * ___demande_essai_pro.nbHeures
     *
     * @var int
     *
     * @ORM\Column(name="nb_heures", type="integer")
     */
    private $nbHeures;

    /**
     * ___demande_essai_pro.priseReference
     *
     * @var string
     *
     * @ORM\Column(name="prise_reference", type="string")
     */
    private $priseReference;

    /**
     * ___demande_essai_pro.telephone
     *
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=25)
     */
    private $telephone;

    /**
     * ___demande_essai_pro.carteId
     *
     * @var string
     *
     * @ORM\Column(name="carte_id", type="string", length=255)
     */
    protected $carteId;

    /**
     * ___demande_essai_pro.rib
     *
     * @var string
     *
     * @ORM\Column(name="rib", type="string", length=255)
     */
    protected $rib;

    protected $nameDemande ='DemandeEssaiProfessionnel';
    protected $typeForm ='Demande d\'essai professionnel';
    protected $subject ='inconnu';
    protected $service ='juridique';

    /**
     * Get nameDemande
     *
     * @return integer
     */
    public function getNameDemande()
    {
        return $this->nameDemande;
    }

    /**
     * Get typeForm
     *
     * @return integer
     */
    public function getTypeForm()
    {
        return $this->typeForm;
    }
    /**
     * Get service
     *
     * @return integer
     */
    public function getService()
    {
        return $this->service;
    }


    /**
     * Get subject
     *
     * @return integer
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return DemandeEssaiProfessionnel
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return DemandeEssaiProfessionnel
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
     * @return DemandeEssaiProfessionnel
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return DemandeEssaiProfessionnel
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
     * Set lieuNaissance
     *
     * @param string $lieuNaissance
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    /**
     * Get lieuNaissance
     *
     * @return string
     */
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
    }

    /**
     * Set departement
     *
     * @param string $departement
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return string
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set numSecu
     *
     * @param string $numSecu
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setNumSecu($numSecu)
    {
        $this->numSecu = $numSecu;

        return $this;
    }

    /**
     * Get numSecu
     *
     * @return string
     */
    public function getNumSecu()
    {
        return $this->numSecu;
    }

    /**
     * Set dateEssai
     *
     * @param \DateTime $dateEssai
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setDateEssai($dateEssai)
    {
        $this->dateEssai = $dateEssai;

        return $this;
    }

    /**
     * Get dateEssai
     *
     * @return \DateTime
     */
    public function getDateEssai()
    {
        return $this->dateEssai;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set diplomes
     *
     * @param array $diplomes
     *
     * @return DemandeEssaiProfessionnel
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
     * Set qualification
     *
     * @param string $qualification
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set nbHeures
     *
     * @param integer $nbHeures
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setNbHeures($nbHeures)
    {
        $this->nbHeures = $nbHeures;

        return $this;
    }

    /**
     * Get nbHeures
     *
     * @return integer
     */
    public function getNbHeures()
    {
        return $this->nbHeures;
    }

    /**
     * Set priseReference
     *
     * @param string $priseReference
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setPriseReference($priseReference)
    {
        $this->priseReference = $priseReference;

        return $this;
    }

    /**
     * Get priseReference
     *
     * @return string
     */
    public function getPriseReference()
    {
        return $this->priseReference;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set carteId
     *
     * @param string $carteId
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setCarteId($carteId)
    {
        $this->carteId = $carteId;

        return $this;
    }

    /**
     * Get carteId
     *
     * @return string
     */
    public function getCarteId()
    {
        return $this->carteId;
    }

    /**
     * Set rib
     *
     * @param string $rib
     *
     * @return DemandeEssaiProfessionnel
     */
    public function setRib($rib)
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * Get rib
     *
     * @return string
     */
    public function getRib()
    {
        return $this->rib;
    }
}
