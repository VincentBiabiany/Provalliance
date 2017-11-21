<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeEntity;

/**
 * DemandeEmbauche
 *
 * @ORM\Table(name="demande_rupture_cdd")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeRuptureCdd")
 */
class DemandeRuptureCdd extends DemandeForm
{
  protected $nameDemande ='DemandeRuptureCdd';
  protected $typeForm ='Demande de rupture CDD';
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
   * ___demande_rupture_cdd.nomCol
   *
   * @var int
   *
   * @ORM\Column(name="matricule", type="integer", nullable=false)
   */
  private $matricule;

  /**
   * ___demande_rupture_cdd.raison
   *
   * @var string
   *
   * @ORM\Column(name="raison", type="string", length=255)
   */
  private $raison;


  /**
   * ___demande_rupture_cdd.ruptAnt
   *
  * @var string
  *
  * @ORM\Column(name="rupture_anticipe", type="string", length=255, nullable=true)
  */
 private $ruptureAncticipe;


  /**
   * ___demande_rupture_cdd.date1
   *
   * @var string
   *
   * @ORM\Column(name="date_debut", type="date", length=255, nullable=true)
   */
  private $dateFin;

  /**
   * ___demande_rupture_cdd.date2
   *
   * @var string
   *
   * @ORM\Column(name="date_fin", type="date", length=255, nullable=true)
   */
  private $dateDepart;


  /**
   * ___demande_rupture_cdd.pj
   *
   * @var string
   *
   * @ORM\Column(name="lettre", type="string", length=255, nullable=true)
   */
  protected $lettre;

  /**
   * ___demande_rupture_cdd.collaborateur
   *
   * @var string
   *
   * @ORM\Column(name="nom_collab", type="string", length=255, nullable=true)
   */
  protected $nomCollab;


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
     * @return DemandeRuptureCdd
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
     * @return DemandeRuptureCdd
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
     * Set ruptureAncticipe
     *
     * @param string $ruptureAncticipe
     *
     * @return DemandeRuptureCdd
     */
    public function setRuptureAncticipe($ruptureAncticipe)
    {
        $this->ruptureAncticipe = $ruptureAncticipe;

        return $this;
    }

    /**
     * Get ruptureAncticipe
     *
     * @return string
     */
    public function getRuptureAncticipe()
    {
        return $this->ruptureAncticipe;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return DemandeRuptureCdd
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
     * Set dateDepart
     *
     * @param \DateTime $dateDepart
     *
     * @return DemandeRuptureCdd
     */
    public function setDateDepart($dateDepart)
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    /**
     * Get dateDepart
     *
     * @return \DateTime
     */
    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    /**
     * Set lettre
     *
     * @param string $lettre
     *
     * @return DemandeRuptureCdd
     */
    public function setLettre($lettre)
    {
        $this->lettre = $lettre;

        return $this;
    }

    /**
     * Get lettre
     *
     * @return string
     */
    public function getLettre()
    {
        return $this->lettre;
    }

    /**
     * Set nomCollab
     *
     * @param string $nomCollab
     *
     * @return DemandeRuptureCdd
     */
    public function setNomCollab($nomCollab)
    {
        $this->nomCollab = $nomCollab;

        return $this;
    }

    /**
     * Get nomCollab
     *
     * @return string
     */
    public function getNomCollab()
    {
        return $this->nomCollab;
    }
}
