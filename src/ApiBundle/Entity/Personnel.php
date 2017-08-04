<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnel
 *
 * @ORM\Table(name="personnel", indexes={@ORM\Index(name="fk_Personnel_Adresse1_idx", columns={"Adresse_id"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_embauche", type="datetime", nullable=true)
     */
    private $dateEmbauche;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_contrat", type="datetime", nullable=true)
     */
    private $dateFinContrat;

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
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Adresse", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Adresse_id", referencedColumnName="id")
     * })
     */
    private $adresse;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Profession", inversedBy="personnel", cascade={"persist"})
     * @ORM\JoinTable(name="personnel_has_profession",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Personnel_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Profession_id", referencedColumnName="id")
     *   }
     * )
     */
    private $profession;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profession = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateEmbauche
     *
     * @param \DateTime $dateEmbauche
     *
     * @return Personnel
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
     * Set dateFinContrat
     *
     * @param \DateTime $dateFinContrat
     *
     * @return Personnel
     */
    public function setDateFinContrat($dateFinContrat)
    {
        $this->dateFinContrat = $dateFinContrat;

        return $this;
    }

    /**
     * Get dateFinContrat
     *
     * @return \DateTime
     */
    public function getDateFinContrat()
    {
        return $this->dateFinContrat;
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
     * Add profession
     *
     * @param \ApiBundle\Entity\Profession $profession
     *
     * @return Personnel
     */
    public function addProfession(\ApiBundle\Entity\Profession $profession)
    {
        $this->profession[] = $profession;

        return $this;
    }

    /**
     * Remove profession
     *
     * @param \ApiBundle\Entity\Profession $profession
     */
    public function removeProfession(\ApiBundle\Entity\Profession $profession)
    {
        $this->profession->removeElement($profession);
    }

    /**
     * Get profession
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfession()
    {
        return $this->profession;
    }
}
