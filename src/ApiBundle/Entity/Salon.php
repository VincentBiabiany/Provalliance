<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salon
 *
 * @ORM\Table(name="salon", indexes={@ORM\Index(name="fk_Salon_Enseigne1_idx", columns={"Enseigne_id"}), @ORM\Index(name="fk_Salon_Adresse1_idx", columns={"Adresse_id"}), @ORM\Index(name="fk_Salon_Groupe1_idx", columns={"Groupe_id"})})
 * @ORM\Entity
 */
class Salon
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
     * @ORM\Column(name="code_interne", type="string", length=45, nullable=true)
     */
    private $codeInterne;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=45, nullable=true)
     */
    private $siret;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fermeture", type="datetime", nullable=true)
     */
    private $dateFermeture;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=45, nullable=true)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="langue_defaut", type="string", length=45, nullable=true)
     */
    private $langueDefaut;

    /**
     * @var string
     *
     * @ORM\Column(name="sage_paie", type="integer", nullable=true)
     */
    private $sagePaie;

    /**
     * @var string
     *
     * @ORM\Column(name="marlix", type="string", length=255, nullable=true)
     */
    private $marlix;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ApiBundle\Entity\Groupe
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Groupe",  cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Groupe_id", referencedColumnName="id", nullable=true,)
     * })
     */
    private $groupe;

    /**
     * @var \ApiBundle\Entity\Enseigne
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Enseigne", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Enseigne_id", referencedColumnName="id")
     * })
     */
    private $enseigne;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Salon
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
     * Set codeInterne
     *
     * @param string $codeInterne
     *
     * @return Salon
     */
    public function setCodeInterne($codeInterne)
    {
        $this->codeInterne = $codeInterne;

        return $this;
    }

    /**
     * Get codeInterne
     *
     * @return string
     */
    public function getCodeInterne()
    {
        return $this->codeInterne;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return Salon
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set dateCreation
     *
     * @param string $dateCreation
     *
     * @return Salon
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return string
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateFermeture
     *
     * @param string $dateFermeture
     *
     * @return Salon
     */
    public function setDateFermeture($dateFermeture)
    {
        $this->dateFermeture = $dateFermeture;

        return $this;
    }

    /**
     * Get dateFermeture
     *
     * @return string
     */
    public function getDateFermeture()
    {
        return $this->dateFermeture;
    }

    /**
     * Set marque
     *
     * @param string $marque
     *
     * @return Salon
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set langueDefaut
     *
     * @param string $langueDefaut
     *
     * @return Salon
     */
    public function setLangueDefaut($langueDefaut)
    {
        $this->langueDefaut = $langueDefaut;

        return $this;
    }

    /**
     * Get langueDefaut
     *
     * @return string
     */
    public function getLangueDefaut()
    {
        return $this->langueDefaut;
    }


    /**
     * Set marlix
     *
     * @param string $marlix
     *
     * @return Personnel
     */
    public function setMarlix($marlix)
    {
        $this->marlix = $marlix;

        return $this;
    }

    /**
     * Get marlix
     *
     * @return string
     */
    public function getMarlix()
    {
        return $this->marlix;
    }

    /**
     * Set sagePaie
     *
     * @param int $sagePaie
     *
     * @return Personnel
     */
    public function setSagePaie($sagePaie)
    {
        $this->sagePaie = $sagePaie;

        return $this;
    }

    /**
     * Get sagePaie
     *
     * @return int
     */
    public function getSagePaie()
    {
        return $this->sagePaie;
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
     * Set groupe
     *
     * @param \ApiBundle\Entity\Groupe $groupe
     *
     * @return Salon
     */
    public function setGroupe(\ApiBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \ApiBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set enseigne
     *
     * @param \ApiBundle\Entity\Enseigne $enseigne
     *
     * @return Salon
     */
    public function setEnseigne(\ApiBundle\Entity\Enseigne $enseigne = null)
    {
        $this->enseigne = $enseigne;

        return $this;
    }

    /**
     * Get enseigne
     *
     * @return \ApiBundle\Entity\Enseigne
     */
    public function getEnseigne()
    {
        return $this->enseigne;
    }

    /**
     * Set adresse
     *
     * @param \ApiBundle\Entity\Adresse $adresse
     *
     * @return Salon
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

}
