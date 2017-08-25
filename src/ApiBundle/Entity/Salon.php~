<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salon
 *
 * @ORM\Table(name="referentiel.salon", indexes={@ORM\Index(name="fk_salon_adresse1_idx", columns={"adresse_id"}), @ORM\Index(name="fk_salon_groupe1_idx", columns={"groupe_id"}), @ORM\Index(name="fk_salon_enseigne1_idx", columns={"enseigne_id"}), @ORM\Index(name="fk_salon_date1_idx", columns={"date_id"})})
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
     * @ORM\Column(name="marlix", type="string", length=20, nullable=true)
     */
    private $marlix;

    /**
     * @var integer
     *
     * @ORM\Column(name="sage_paie", type="integer", nullable=true)
     */
    private $sagePaie;

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
     * @var \ApiBundle\Entity\Date
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Date")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="date_id", referencedColumnName="id")
     * })
     */
    private $date;

    /**
     * @var \ApiBundle\Entity\Enseigne
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Enseigne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enseigne_id", referencedColumnName="id")
     * })
     */
    private $enseigne;

    /**
     * @var \ApiBundle\Entity\Groupe
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Groupe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groupe_id", referencedColumnName="id")
     * })
     */
    private $groupe;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Personnel", mappedBy="referentiel.salon")
     */
    private $personnel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnel = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * @return Salon
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
     * @param integer $sagePaie
     *
     * @return Salon
     */
    public function setSagePaie($sagePaie)
    {
        $this->sagePaie = $sagePaie;

        return $this;
    }

    /**
     * Get sagePaie
     *
     * @return integer
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

    /**
     * Set date
     *
     * @param \ApiBundle\Entity\Date $date
     *
     * @return Salon
     */
    public function setDate(\ApiBundle\Entity\Date $date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \ApiBundle\Entity\Date
     */
    public function getDate()
    {
        return $this->date;
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
     * Add personnel
     *
     * @param \ApiBundle\Entity\Personnel $personnel
     *
     * @return Salon
     */
    public function addPersonnel(\ApiBundle\Entity\Personnel $personnel)
    {
        $this->personnel[] = $personnel;

        return $this;
    }

    /**
     * Remove personnel
     *
     * @param \ApiBundle\Entity\Personnel $personnel
     */
    public function removePersonnel(\ApiBundle\Entity\Personnel $personnel)
    {
        $this->personnel->removeElement($personnel);
    }

    /**
     * Get personnel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }
}
