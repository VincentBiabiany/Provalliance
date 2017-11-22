<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandeAvenant
 *
 * @ORM\Table(name="demande_avenant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeAvenantRepository")
 */
class DemandeAvenant extends DemandeForm
{
  protected $nameDemande ='DemandeAvenant';
  protected $typeForm ='Demande d\'avenant';
  protected $subject ='connu';
  protected $service ='juridique';

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * ___demande_avenant.collaborateur
   *
   * @var int
   *
   * @ORM\Column(name="matricule", type="integer", nullable=false)
   */
  private $matricule;

  /**
   * ___demande_avenant.raison
   *
   * @var string
   *
   * @ORM\Column(name="raison", type="string", length=255, nullable=false)
   */
  private $raison;

  /**
   * ___demande_avenant.du
   *
   * @var string
   *
   * @ORM\Column(name="du", type="date", length=255, nullable=true)
   */
  private $du;

  /**
   * ___demande_avenant.au
   *
   * @var string
   *
   * @ORM\Column(name="au", type="date", length=255, nullable=true)
   */
  private $au;

  /**
   * ___demande_avenant.aPartirDu
   *
   * @var string
   *
   * @ORM\Column(name="a_partir_du", type="date", length=255, nullable=true)
   */
  private $aPartirDu;

  /**
   * ___demande_avenant.TempsPartiel
   *
   * @var array
   *
   * @ORM\Column(name="temps_partiel", type="array", nullable=true)
   */
  private $tempsPartiel;

  /**
   * ___demande_avenant.arretMaladie
   *
   * @var string
   *
   * @ORM\Column(name="arret_maladie", type="string", length=255, nullable=true)
   */
  protected $arretMaladie;

  /**
   * ___demande_avenant.avisMed
   *
   * @var string
   *
   * @ORM\Column(name="avis_med", type="string", length=255, nullable=true)
   */
  protected $avisMed;

  /**
   * ___demande_avenant.courrierLabel
   *
   * @var string
   *
   * @ORM\Column(name="courrier", type="string", length=255, nullable=true)
   */
  protected $courrier;

  /**
   * ___demande_avenant.fixe
   *
   * @var int
   *
   * @ORM\Column(name="salaire_fixe", type="integer", nullable=true)
   */
  protected $salaireFixe;

  /**
   * ___demande_avenant.variable
   *
   * @var int
   *
   * @ORM\Column(name="salaire_var_mens", type="integer", nullable=true)
   */
  protected $salaireMens;

  /**
   * ___demande_avenant.trim
   *
   * @var int
   *
   * @ORM\Column(name="salaire_var_trim", type="integer", nullable=true)
   */
  protected $salaireTrim;


  public function __construct()
  {
    $this->tempsPartiel = ['lundi'=>0, 'mardi'=>0,'mercredi'=>0, 'jeudi'=>0,'vendredi'=>0,'samedi'=>0,'total'=>0];
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
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return DemandeAvenant
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
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
     * Set raison
     *
     * @param string $raison
     *
     * @return DemandeAvenant
     */
    public function setRaison($raison)
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * Get raison
     *
     * @return string
     */
    public function getRaison()
    {
        return $this->raison;
    }

    /**
     * Set du
     *
     * @param \DateTime $du
     *
     * @return DemandeAvenant
     */
    public function setDu($du)
    {
        $this->du = $du;

        return $this;
    }

    /**
     * Get du
     *
     * @return \DateTime
     */
    public function getDu()
    {
        return $this->du;
    }

    /**
     * Set au
     *
     * @param \DateTime $au
     *
     * @return DemandeAvenant
     */
    public function setAu($au)
    {
        $this->au = $au;

        return $this;
    }

    /**
     * Get au
     *
     * @return \DateTime
     */
    public function getAu()
    {
        return $this->au;
    }

    /**
     * Set aPartirDu
     *
     * @param \DateTime $aPartirDu
     *
     * @return DemandeAvenant
     */
    public function setaPartirDu($aPartirDu)
    {
        $this->aPartirDu = $aPartirDu;

        return $this;
    }

    /**
     * Get aPartirDu
     *
     * @return \DateTime
     */
    public function getaPartirDu()
    {
        return $this->aPartirDu;
    }

    /**
     * Set tempsPartiel
     *
     * @param array $tempsPartiel
     *
     * @return DemandeAvenant
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
     * Set arretMaladie
     *
     * @param string $arretMaladie
     *
     * @return DemandeAvenant
     */
    public function setArretMaladie($arretMaladie)
    {
        $this->arretMaladie = $arretMaladie;

        return $this;
    }

    /**
     * Get arretMaladie
     *
     * @return string
     */
    public function getArretMaladie()
    {
        return $this->arretMaladie;
    }

    /**
     * Set avisMed
     *
     * @param string $avisMed
     *
     * @return DemandeAvenant
     */
    public function setAvisMed($avisMed)
    {
        $this->avisMed = $avisMed;

        return $this;
    }

    /**
     * Get avisMed
     *
     * @return string
     */
    public function getAvisMed()
    {
        return $this->avisMed;
    }

    /**
     * Set courrier
     *
     * @param string $courrier
     *
     * @return DemandeAvenant
     */
    public function setCourrier($courrier)
    {
        $this->courrier = $courrier;

        return $this;
    }

    /**
     * Get courrier
     *
     * @return string
     */
    public function getCourrier()
    {
        return $this->courrier;
    }

    /**
     * Set salaireFixe
     *
     * @param integer $salaireFixe
     *
     * @return DemandeAvenant
     */
    public function setSalaireFixe($salaireFixe)
    {
        $this->salaireFixe = $salaireFixe;

        return $this;
    }

    /**
     * Get salaireFixe
     *
     * @return integer
     */
    public function getSalaireFixe()
    {
        return $this->salaireFixe;
    }

    /**
     * Set salaireMens
     *
     * @param integer $salaireMens
     *
     * @return DemandeAvenant
     */
    public function setSalaireMens($salaireMens)
    {
        $this->salaireMens = $salaireMens;

        return $this;
    }

    /**
     * Get salaireMens
     *
     * @return integer
     */
    public function getSalaireMens()
    {
        return $this->salaireMens;
    }

    /**
     * Set salaireTrim
     *
     * @param integer $salaireTrim
     *
     * @return DemandeAvenant
     */
    public function setSalaireTrim($salaireTrim)
    {
        $this->salaireTrim = $salaireTrim;

        return $this;
    }

    /**
     * Get salaireTrim
     *
     * @return integer
     */
    public function getSalaireTrim()
    {
        return $this->salaireTrim;
    }
}
