<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Personnel
 *
 * @ORM\Table(name="referentiel.personnel", indexes={@ORM\Index(name="fk_personnel_adresse1_idx", columns={"adresse_id"})})
 * @ORM\Entity
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
     * @var string
     *
     * @ORM\Column(name="type_contrat", type="string", length=45, nullable=true)
     */
    private $typeContrat;

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
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Salon", inversedBy="referentiel.personnel")
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
     * Set typeContrat
     *
     * @param string $typeContrat
     *
     * @return Personnel
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSalon()
    {
        return $this->salon;
    }
}
