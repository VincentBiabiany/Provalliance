<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salon
 *
 * @ORM\Table(name="salon", indexes={@ORM\Index(name="fk_salon_groupe1_idx", columns={"groupe_id"}), @ORM\Index(name="fk_salon_enseigne1_idx", columns={"enseigne_id"}), @ORM\Index(name="fk_salon_pays1_idx", columns={"pays_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\SalonRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Salon
{
    /**
     * @var string
     *
     * @ORM\Column(name="appelation", type="string", length=100, nullable=true)
     */
    private $appelation;

    /**
     * @var string
     *
     * @ORM\Column(name="forme_juridique", type="string", length=60, nullable=true)
     */
    private $formeJuridique;

    /**
     * @var string
     *
     * @ORM\Column(name="rcs_ville", type="string", length=80, nullable=true)
     */
    private $rcsVille;

    /**
     * @var string
     *
     * @ORM\Column(name="code_naf", type="string", length=6, nullable=true)
     */
    private $codeNaf;

    /**
     * @var string
     *
     * @ORM\Column(name="siren", type="string", length=45, nullable=true)
     */
    private $siren;

    /**
     * @var string
     *
     * @ORM\Column(name="capital", type="string", length=45, nullable=true)
     */
    private $capital;

    /**
     * @var string
     *
     * @ORM\Column(name="raison_sociale", type="string", length=45, nullable=true)
     */
    private $raisonSociale;

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
     * @ORM\Column(name="code_postal", type="string", length=15, nullable=true)
     */
    private $codePostal;

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
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="code_marlix", type="string", length=20, nullable=true)
     */
    private $codeMarlix;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ouverture", type="date", nullable=true)
     */
    private $dateOuverture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fermeture_sociale", type="date", nullable=true)
     */
    private $dateFermetureSociale;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fermeture_commerciale", type="date", nullable=true)
     */
    private $dateFermetureCommerciale;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @var integer
     *
     * @ORM\Column(name="sage", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sage;

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
     * @var \ApiBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pays_id", referencedColumnName="id")
     * })
     */
    private $pays;


    /**
     * @ORM\PostLoad
     */
    public function onPostLoad()
    {
        $now = (new \DateTime())->format('Y-m-d');

        if ($this->dateFermetureSociale->format('Y-m-d') <= $now)
          $this->actif = 0;
        else
          $this->actif = 1;
    }

    /**
     * Set appelation
     *
     * @param string $appelation
     *
     * @return Salon
     */
    public function setAppelation($appelation)
    {
        $this->appelation = $appelation;

        return $this;
    }

    /**
     * Get appelation
     *
     * @return string
     */
    public function getAppelation()
    {
        return $this->appelation;
    }

    /**
     * Set formeJuridique
     *
     * @param string $formeJuridique
     *
     * @return Salon
     */
    public function setFormeJuridique($formeJuridique)
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    /**
     * Get formeJuridique
     *
     * @return string
     */
    public function getFormeJuridique()
    {
        return $this->formeJuridique;
    }

    /**
     * Set rcsVille
     *
     * @param string $rcsVille
     *
     * @return Salon
     */
    public function setRcsVille($rcsVille)
    {
        $this->rcsVille = $rcsVille;

        return $this;
    }

    /**
     * Get rcsVille
     *
     * @return string
     */
    public function getRcsVille()
    {
        return $this->rcsVille;
    }

    /**
     * Set codeNaf
     *
     * @param string $codeNaf
     *
     * @return Salon
     */
    public function setCodeNaf($codeNaf)
    {
        $this->codeNaf = $codeNaf;

        return $this;
    }

    /**
     * Get codeNaf
     *
     * @return string
     */
    public function getCodeNaf()
    {
        return $this->codeNaf;
    }

    /**
     * Set siren
     *
     * @param string $siren
     *
     * @return Salon
     */
    public function setSiren($siren)
    {
        $this->siren = $siren;

        return $this;
    }

    /**
     * Get siren
     *
     * @return string
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * Set capital
     *
     * @param string $capital
     *
     * @return Salon
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * Get capital
     *
     * @return string
     */
    public function getCapital()
    {
        return $this->capital;
    }

    /**
     * Set raisonSociale
     *
     * @param string $raisonSociale
     *
     * @return Salon
     */
    public function setRaisonSociale($raisonSociale)
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    /**
     * Get raisonSociale
     *
     * @return string
     */
    public function getRaisonSociale()
    {
        return $this->raisonSociale;
    }

    /**
     * Set adresse1
     *
     * @param string $adresse1
     *
     * @return Salon
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
     * @return Salon
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
     * @return Salon
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
     * @return Salon
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
     * @return Salon
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
     * @return Salon
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
     * @return Salon
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
     * Set codeMarlix
     *
     * @param string $codeMarlix
     *
     * @return Salon
     */
    public function setCodeMarlix($codeMarlix)
    {
        $this->codeMarlix = $codeMarlix;

        return $this;
    }

    /**
     * Get codeMarlix
     *
     * @return string
     */
    public function getCodeMarlix()
    {
        return $this->codeMarlix;
    }

    /**
     * Set dateOuverture
     *
     * @param \DateTime $dateOuverture
     *
     * @return Salon
     */
    public function setDateOuverture($dateOuverture)
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    /**
     * Get dateOuverture
     *
     * @return \DateTime
     */
    public function getDateOuverture()
    {
        return $this->dateOuverture;
    }

    /**
     * Set dateFermetureSociale
     *
     * @param \DateTime $dateFermetureSociale
     *
     * @return Salon
     */
    public function setDateFermetureSociale($dateFermetureSociale)
    {
        $this->dateFermetureSociale = $dateFermetureSociale;

        return $this;
    }

    /**
     * Get dateFermetureSociale
     *
     * @return \DateTime
     */
    public function getDateFermetureSociale()
    {
        return $this->dateFermetureSociale;
    }

    /**
     * Set dateFermetureCommerciale
     *
     * @param \DateTime $dateFermetureCommerciale
     *
     * @return Salon
     */
    public function setDateFermetureCommerciale($dateFermetureCommerciale)
    {
        $this->dateFermetureCommerciale = $dateFermetureCommerciale;

        return $this;
    }

    /**
     * Get dateFermetureCommerciale
     *
     * @return \DateTime
     */
    public function getDateFermetureCommerciale()
    {
        return $this->dateFermetureCommerciale;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Salon
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
     * Get sage
     *
     * @return integer
     */
    public function getSage()
    {
        return $this->sage;
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
     * Set pays
     *
     * @param \ApiBundle\Entity\Pays $pays
     *
     * @return Salon
     */
    public function setPays(\ApiBundle\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \ApiBundle\Entity\Pays
     */
    public function getPays()
    {
        return $this->pays;
    }
}
