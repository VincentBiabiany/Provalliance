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
   * @var int
   *
   * @ORM\Column(name="matricule", type="integer", nullable=false)
   */
  private $matricule;

  /**
   * ___avenant.du
   *
   * @var string
   *
   * @ORM\Column(name="date_debut", type="date", length=255, nullable=true)
   */
  private $dateDebut;

  /**
   * ___avenant.au
   *
   * @var string
   *
   * @ORM\Column(name="date_fin", type="date", length=255, nullable=true)
   */
  private $dateFin;

  /**
   * ___avenant.raison
   *
   * @var string
   *
   * @ORM\Column(name="raison", type="string", length=255, nullable=false)
   */
  private $raison;

  /**
   * ___avenant.collab
   *
   * @var array
   *
   * @ORM\Column(name="temps_partiel", type="array", nullable=true)
   */
  private $tempsPartiel;

  /**
   * ___avenant.pj
   *
   * @var string
   *
   * @ORM\Column(name="piece_jointe1", type="string", length=255, nullable=true)
   */
  protected $pieceJointe1;

  /**
   * ___avenant.pj
   *
   * @var string
   *
   * @ORM\Column(name="piece_jointe2", type="string", length=255, nullable=true)
   */
  protected $pieceJointe2;

  /**
   * ___avenant.fixe
   *
   * @var int
   *
   * @ORM\Column(name="salaire_fixe", type="integer", nullable=true)
   */
  protected $salaireFixe;

  /**
   * ___avenant.variable
   *
   * @var int
   *
   * @ORM\Column(name="salaire_var_mens", type="integer", nullable=true)
   */
  protected $salaireMens;

  /**
   * ___avenant.trim
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return DemandeAvenant
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return DemandeAvenant
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
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
     * Set pieceJointe1
     *
     * @param string $pieceJointe1
     *
     * @return DemandeAvenant
     */
    public function setPieceJointe1($pieceJointe1)
    {
        $this->pieceJointe1 = $pieceJointe1;

        return $this;
    }

    /**
     * Get pieceJointe1
     *
     * @return string
     */
    public function getPieceJointe1()
    {
        return $this->pieceJointe1;
    }

    /**
     * Set pieceJointe2
     *
     * @param string $pieceJointe2
     *
     * @return DemandeAvenant
     */
    public function setPieceJointe2($pieceJointe2)
    {
        $this->pieceJointe2 = $pieceJointe2;

        return $this;
    }

    /**
     * Get pieceJointe2
     *
     * @return string
     */
    public function getPieceJointe2()
    {
        return $this->pieceJointe2;
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
