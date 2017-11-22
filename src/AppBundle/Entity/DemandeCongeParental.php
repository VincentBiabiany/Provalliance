<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;


/**
 * AppBundle\Entity\DemandeAcompte
 *
 * @ORM\Table(name="demande_conge_parental")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeCongeParentalRepository")
 */
class DemandeCongeParental extends DemandeForm
{
  protected $nameDemande ='DemandeCongeParental';
  protected $typeForm ='Demande de congé parental';
  protected $subject ='connu';
  protected $service ='juridique';
  protected $nomDoc = 'conge_parental';

  /**
   * ___demande_conge_parental.collab
   *
   * @var int
   *
   * @ORM\Column(name="matricule", type="integer")
   */
  private $matricule;

  /**
   * ___demande_conge_parental.raison
   *
   * @var string
   *
   * @ORM\Column(name="raison", type="string", length=255, nullable=true)
   */
  private $raison;

  /**
   * ___demande_conge_parental.tempsPartiel
   *
   * @var array
   *
   * @ORM\Column(name="temps_partiel", type="array", nullable=true)
   */
  private $tempsPartiel;

  /**
   * ___demande_conge_parental.du
   *
   * @var string
   *
   * @ORM\Column(name="du", type="date", length=255, nullable=true)
   */
  private $du;

  /**
   * ___demande_conge_parental.au
   *
   * @var string
   *
   * @ORM\Column(name="au", type="date", length=255, nullable=true)
   */
  private $au;

  /**
   * ___demande_conge_parental.le
   *
   * @var string
   *
   * @ORM\Column(name="date_debut", type="date", length=255, nullable=true)
   */
  private $le;

  /**
   * ___demande_conge_parental.aulieu
   *
   * @var string
   *
   * @ORM\Column(name="date_fin", type="date", length=255, nullable=true)
   */
  private $aulieu;

  /**
   * ___demande_conge_parental.lettreLabel
   *
   * @var string
   *
   * @ORM\Column(name="piece_jointe", type="string", length=255, nullable=false)
   */
  protected $pieceJointe;


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
   * Get nomDoc
   *
   * @return integer
   */
  public function getNomDoc()
  {
      return $this->nomDoc;
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
     * @return DemandeCongeParental
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
     * @return DemandeCongeParental
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
     * @return DemandeCongeParental
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
     * Set du
     *
     * @param \DateTime $du
     *
     * @return DemandeCongeParental
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
     * @return DemandeCongeParental
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
     * Set le
     *
     * @param \DateTime $le
     *
     * @return DemandeCongeParental
     */
    public function setLe($le)
    {
        $this->le = $le;

        return $this;
    }

    /**
     * Get le
     *
     * @return \DateTime
     */
    public function getLe()
    {
        return $this->le;
    }

    /**
     * Set aulieu
     *
     * @param \DateTime $aulieu
     *
     * @return DemandeCongeParental
     */
    public function setAulieu($aulieu)
    {
        $this->aulieu = $aulieu;

        return $this;
    }

    /**
     * Get aulieu
     *
     * @return \DateTime
     */
    public function getAulieu()
    {
        return $this->aulieu;
    }

    /**
     * Set pieceJointe
     *
     * @param string $pieceJointe
     *
     * @return DemandeCongeParental
     */
    public function setPieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return string
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }
}
