<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnel
 *
 * @ORM\Table(name="personnel")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\PersonnelRepository")
 */
class Personnel
{
    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=10, nullable=true)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=60, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=60, nullable=true)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="datetime", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_naissance", type="string", length=80, nullable=true)
     */
    private $villeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="pays_naissance", type="string", length=80, nullable=true)
     */
    private $paysNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=60, nullable=true)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=60, nullable=true)
     */
    private $niveau;

    /**
     * @var string
     *
     * @ORM\Column(name="echelon", type="string", length=60, nullable=true)
     */
    private $echelon;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse1", type="string", length=80, nullable=true)
     */
    private $adresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse2", type="string", length=80, nullable=true)
     */
    private $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="codepostal", type="string", length=20, nullable=true)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=80, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone1", type="string", length=45, nullable=true)
     */
    private $telephone1;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone2", type="string", length=45, nullable=true)
     */
    private $telephone2;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, nullable=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="matricule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $matricule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Salon", inversedBy="salon_sage")
     * @ORM\JoinTable(name="personnel_has_salon",
     *   joinColumns={
     *     @ORM\JoinColumn(name="personnel_matricule", referencedColumnName="matricule")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="salon_sage", referencedColumnName="sage")
     *   }
     * )
     */
    private $salon;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salon = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Personnel
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Personnel
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
     * @return Personnel
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Personnel
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
     * @return Personnel
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
     * Set paysNaissance
     *
     * @param string $paysNaissance
     *
     * @return Personnel
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
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Personnel
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
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return Personnel
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
     * Set niveau
     *
     * @param string $niveau
     *
     * @return Personnel
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
     * @return Personnel
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
     * Set adresse1
     *
     * @param string $adresse1
     *
     * @return Personnel
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
     * @return Personnel
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
     * Set codepostal
     *
     * @param string $codepostal
     *
     * @return Personnel
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Personnel
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
     * Set telephone1
     *
     * @param string $telephone1
     *
     * @return Personnel
     */
    public function setTelephone1($telephone1)
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    /**
     * Get telephone1
     *
     * @return string
     */
    public function getTelephone1()
    {
        return $this->telephone1;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     *
     * @return Personnel
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * Get telephone2
     *
     * @return string
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Personnel
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
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Personnel
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Get matricule
     *
     * @return integer
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Add salon
     *
     * @param \ApiBundle\Entity\Salon $salon
     *
     * @return Personnel
     */
    public function addSalon(\ApiBundle\Entity\Salon $salon)
    {
        $this->salon[] = $salon;
        return $this;
    }
    /**
     * Remove salon
     *
     * @param \ApiBundle\Entity\Salon $salon
     */
    public function removeSalon(\ApiBundle\Entity\Salon $salon)
    {
        $this->salon->removeElement($salon);
    }
    /**
     * Get salon
     *
     * @return Salon
     */
    public function getSalon()
    {
        return $this->salon;
    }
}
