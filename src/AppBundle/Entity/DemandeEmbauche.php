<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * DemandeEmbauche
 *
 * @ORM\Table(name="demande_embauche")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeEmbaucheRepository")
 */
class DemandeEmbauche extends DemandeForm
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
     * ___demande_embauche.nom
     *
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255 )
     */
    private $nom;

    /**
     * ___demande_embauche.prenom
     *
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * ___demande_embauche.adr1
     *
     * @var string
     *
     * @ORM\Column(name="adresse_1", type="string", length=255)
     */
    private $adresse1;

    /**
     * ___demande_embauche.sexe
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * ___demande_embauche.adr2
     *
     * @var string
     *
     * @ORM\Column(name="adresse_2", type="string", length=255, nullable=true)
     */
    private $adresse2;

    /**
     * ___demande_embauche.cp
     *
     *  @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=20)
     */
    private $codePostal;


    /**
     * ___demande_embauche.ville
     *
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * ___demande_embauche.tel
     *
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=25)
     */
    private $telephone;

    /**
     * ___demande_embauche.email
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * ___demande_embauche.ss
     *
     * @var string
     *
     * @ORM\Column(name="num_secu", type="string", length=255)
     */
    private $numSecu;

    /**
     * ___demande_embauche.daten
     *
     * @var string
     *
     * @ORM\Column(name="date_naissance", type="date", length=255)
     */
    private $dateNaissance;

    /**
     * ___demande_embauche.villen
     *
     * @var string
     *
     * @ORM\Column(name="ville_naissance", type="string", length=255)
     */
    private $villeNaissance;

    /**
     * ___demande_embauche.paysNaissance
     *
     * @var string
     *
     * @ORM\Column(name="pays_naissance", type="string", length=255)
     */
    private $paysNaissance;

    /**
     * ___demande_embauche.nat
     *
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * ___demande_embauche.nbenf
     *
     * @var int
     *
     * @ORM\Column(name="nb_enfant", type="integer", nullable=true)
     */
    private $nbEnfant;

    /**
     * ___demande_embauche.fam
     *
     * @var string
     *
     * @ORM\Column(name="situation_famille", type="string")
     */
    private $situationFamille;

    /**
     * ___demande_embauche.dateemb
     *
     * @var string
     *
     * @ORM\Column(name="date_embauche", type="date", length=255)
     */
    private $dateEmbauche;

    /**
     * ___demande_embauche.ancien
     *
     * @var string
     *
     * @ORM\Column(name="deja_salarie", type="string", length=255)
     */
    private $dejaSalarie;

    /**
     * ___demande_embauche.lieu
     *
     * @var string
     *
     * @ORM\Column(name="salarie_lieu", type="string", length=255,  nullable=true)
     */
    private $salarieLieu;

    /**
     * ___demande_embauche.poste
     *
     * @var string
     *
     * @ORM\Column(name="postes", type="string", length=255)
     */
    private $postes;

    /**
     * ___demande_embauche.diplomes
     *
     * @var array
     *
     * @ORM\Column(name="diplomes", type="array")
     */
    private $diplomes;

    /**
     * ___demande_embauche.niveau
     *
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255,  nullable=true)
     */
    private $niveau;

    /**
     * ___demande_embauche.echelon
     *
     * @var string
     *
     * @ORM\Column(name="echelon", type="string", length=255,  nullable=true)
     */
    private $echelon;

    /**
     * ___demande_embauche.nom
     *
     * @var string
     *
     * @ORM\Column(name="autre", type="string", length=255,  nullable=true)
     */
    private $autre;

    /**
     * ___demande_embauche.salaire
     *
     * @var int
     *
     * @ORM\Column(name="salaire_base", type="integer")
     */
    private $salaireBase;

    /**
     * ___demande_embauche.contrat
     *
     * @var string
     *
     * @ORM\Column(name="type_contrat", type="string", length=255,  nullable=true)
     */
    private $typeContrat;

    /**
     * ___demande_embauche.cdd
     *
     * @var string
     *
     * @ORM\Column(name="cdd_raison", type="string", length=255,  nullable=true)
     */
    private $cddRaison;

    /**
     * ___demande_embauche.cdd.nature
     *
     * @var string
     *
     * @ORM\Column(name="remplacement_nature", type="string", length=255,  nullable=true)
     */
    private $remplacementNature;

    /**
     * ___demande_embauche.cdd.date
     *
     * @var string
     *
     * @ORM\Column(name="cdd_date", type="date", length=255,  nullable=true)
     */
    private $cddDate;

    /**
     * ___demande_embauche.cdd.partiel
     *
     * @var string
     *
     * @ORM\Column(name="precision_date", type="string", length=255, nullable=true)
     */
    private $precisionDate;

    /**
     * ___demande_embauche.cdd.nom
     *
     * @var string
     *
     * @ORM\Column(name="remplacement_nom", type="string", length=255,  nullable=true)
     */
    private $remplacementNom;

    /**
     * ___demande_embauche.partiel
     *
     * @var array
     *
     * @ORM\Column(name="is_temps_partiel", type="string", length=255)
     */
    private $isTempsPartiel;

    /**
     * ___demande_embauche.cdd.partiel
     *
     * @var array
     *
     * @ORM\Column(name="temps_partiel", type="array",  nullable=true)
     */
    private $tempsPartiel;

    /**
     * ___demande_embauchepi
     *
     * @var string
     *
     * @ORM\Column(name="carte_id", type="string", length=255)
     */
    protected $carteId;

    /**
     * ___demande_embauche.diplome
     *
     * @var string
     *
     * @ORM\Column(name="diplome_file", type="string", length=255)
     */
    protected $diplomeFile;

    /**
     * ___demande_embauche.diplome2
     *
     * @var string
     *
     * @ORM\Column(name="diplome_file2", type="string", length=255, nullable=true)
     */
    protected $diplomeFile2;

    /**
     * ___demande_embauche.cartev
     *
     * @var string
     *
     * @ORM\Column(name="carte_vitale", type="string", length=255)
     */
    protected $carteVitale;

    /**
     * ___demande_embauche.rib
     *
     * @var string
     *
     * @ORM\Column(name="rib", type="string", length=255)
     */
    protected $rib;

    /**
     * ___demande_embauche.adhesion
     *
     * @var string
     *
     * @ORM\Column(name="mutuelle", type="string", length=255)
     */
    protected $mutuelle;


    protected $nameDemande ='DemandeEmbauche';
    protected $subject ='inconnu';


    public function __construct()
    {
      $this->tempsPartiel = ['lundi'=>0, 'mardi'=>0,'mercredi'=>0, 'jeudi'=>0,'vendredi'=>0,'samedi'=>0,'total'=>0];
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return DemandeEmbauche
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
     * Set adresse1
     *
     * @param string $adresse1
     *
     * @return DemandeEmbauche
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    /**
     * Get adresse1
     *
     * @return string
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * Set adresse2
     *
     * @param string $adresse2
     *
     * @return DemandeEmbauche
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * Get adresse2
     *
     * @return string
     */
    public function getAdresse2()
    {
        return $this->adresse2;
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
     * @return integer
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
     * @return integer
     */
    public function getNumSecu()
    {
        return $this->numSecu;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
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
     * @return \DateTime
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
     * @return integer
     */
    public function getNbEnfant()
    {
        return $this->nbEnfant;
    }

    /**
     * Set situationFamille
     *
     * @param string $situationFamille
     *
     * @return DemandeEmbauche
     */
    public function setSituationFamille($situationFamille)
    {
        $this->situationFamille = $situationFamille;

        return $this;
    }

    /**
     * Get situationFamille
     *
     * @return string
     */
    public function getSituationFamille()
    {
        return $this->situationFamille;
    }

    /**
     * Set dateEmbauche
     *
     * @param \DateTime $dateEmbauche
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
     * @return \DateTime
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
     * Set precisionDate
     *
     * @param string $precisionDate
     *
     * @return DemandeEmbauche
     */
    public function setprecisionDate($precisionDate)
    {
        $this->precisionDate = $precisionDate;

        return $this;
    }

    /**
     * Get precisionDate
     *
     * @return string
     */
    public function getprecisionDate()
    {
        return $this->precisionDate;
    }

    /**
     * Set $isTempsPartiel
     *
     * @param string $isTempsPartiel
     *
     * @return DemandeEmbauche
     */
    public function setisTempsPartiel($isTempsPartiel)
    {
        $this->isTempsPartiel = $isTempsPartiel;

        return $this;
    }

    /**
     * Get $isTempsPartiel
     *
     * @return string
     */
    public function getisTempsPartiel()
    {
        return $this->isTempsPartiel;
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
     * Set postes
     *
     * @param string $postes
     *
     * @return DemandeEmbauche
     */
    public function setPostes($postes)
    {
        $this->postes = $postes;

        return $this;
    }

    /**
     * Get postes
     *
     * @return string
     */
    public function getPostes()
    {
        return $this->postes;
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
     * Set niveau
     *
     * @param string $niveau
     *
     * @return DemandeEmbauche
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
     * Set cddRaison
     *
     * @param string $cddRaison
     *
     * @return DemandeEmbauche
     */
    public function setCddRaison($cddRaison)
    {
        $this->cddRaison = $cddRaison;

        return $this;
    }

    /**
     * Get cddRaison
     *
     * @return string
     */
    public function getCddRaison()
    {
        return $this->cddRaison;
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
     * Set cddDate
     *
     * @param \DateTime $cddDate
     *
     * @return DemandeEmbauche
     */
    public function setCddDate($cddDate)
    {
        $this->cddDate = $cddDate;

        return $this;
    }

    /**
     * Get cddDate
     *
     * @return \DateTime
     */
    public function getCddDate()
    {
        return $this->cddDate;
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

    /**
     * Set carteId
     *
     * @param string $carteId
     *
     * @return DemandeEmbauche
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
     * Set diplomeFile
     *
     * @param string $diplomeFile
     *
     * @return DemandeEmbauche
     */
    public function setDiplomeFile($diplomeFile)
    {
        $this->diplomeFile = $diplomeFile;

        return $this;
    }

    /**
     * Get diplomeFile
     *
     * @return string
     */
    public function getDiplomeFile()
    {
        return $this->diplomeFile;
    }

    /**
     * Set diplomeFile2
     *
     * @param string $diplomeFile2
     *
     * @return DemandeEmbauche
     */
    public function setDiplomeFile2($diplomeFile2)
    {
        $this->diplomeFile2 = $diplomeFile2;

        return $this;
    }

    /**
     * Get diplomeFile2
     *
     * @return string
     */
    public function getDiplomeFile2()
    {
        return $this->diplomeFile2;
    }

    /**
     * Set carteVitale
     *
     * @param string $carteVitale
     *
     * @return DemandeEmbauche
     */
    public function setCarteVitale($carteVitale)
    {
        $this->carteVitale = $carteVitale;

        return $this;
    }

    /**
     * Get carteVitale
     *
     * @return string
     */
    public function getCarteVitale()
    {
        return $this->carteVitale;
    }

    /**
     * Set rib
     *
     * @param string $rib
     *
     * @return DemandeEmbauche
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

    /**
     * Set mutuelle
     *
     * @param string $mutuelle
     *
     * @return DemandeEmbauche
     */
    public function setMutuelle($mutuelle)
    {
        $this->mutuelle = $mutuelle;

        return $this;
    }

    /**
     * Get mutuelle
     *
     * @return string
     */
    public function getMutuelle()
    {
        return $this->mutuelle;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return DemandeEmbauche
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set paysNaissance
     *
     * @param string $paysNaissance
     *
     * @return DemandeEmbauche
     */
    public function setPaysNaissance($paysNaissance)
    {
        $this->paysNaissance = $paysNaissance;

        return $this;
    }

    /**
     * Get paysNaissance
     *
     * @return string
     */
    public function getPaysNaissance()
    {
        return $this->paysNaissance;
    }

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
     * Get subject
     *
     * @return integer
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
