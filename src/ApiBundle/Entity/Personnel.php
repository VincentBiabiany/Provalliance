<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Personnel
 *
 * @ORM\Table(name="personnel", indexes={@ORM\Index(name="fk_personnel_adresse1_idx", columns={"adresse_id"})})
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\PersonnelRepository")
 */
class Personnel
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=45, nullable=true)
     */
    private $prenom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=45, nullable=true)
     */
    private $matricule;

    /**
     * @var boolean
     *
     * @ORM\Column(name="compte", type="boolean", nullable=true)
     */
    private $compte;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ApiBundle\Entity\Adresse
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adresse_id", referencedColumnName="id")
     * })
     */
    private $adresse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Salon", inversedBy="personnel")
     * @ORM\JoinTable(name="personnel_has_salon",
     *   joinColumns={
     *     @ORM\JoinColumn(name="personnel_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="salon_id", referencedColumnName="id")
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
     * Set compte
     *
     * @param boolean $compte
     *
     * @return Personnel
     */
    public function setCompte($compte)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get compte
     *
     * @return boolean
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Personnel
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adresse
     *
     * @param \ApiBundle\Entity\Adresse $adresse
     *
     * @return Personnel
     */
    public function setAdresse(\ApiBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \ApiBundle\Entity\Adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
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
