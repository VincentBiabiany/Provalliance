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
  protected $nomDoc = 'rupture_cdd';

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
   * ___demande_rupture_cdd.finCddLe
   *
   * @var string
   *
   * @ORM\Column(name="finCddLe", type="date", length=255, nullable=true)
   */
  private $finCddLe;

  /**
   * ___demande_rupture_cdd.retourCollabLe
   *
   * @var string
   *
   * @ORM\Column(name="retour_collab_le", type="date", length=255, nullable=true)
   */
  private $retourCollabLe;

  /**
   * ___demande_rupture_cdd.finCddLe
   *
   * @var string
   *
   * @ORM\Column(name="finCddLe2", type="date", length=255, nullable=true)
   */
  private $finCddLe2;

  /**
   * ___demande_rupture_cdd.departCollabLe
   *
   * @var string
   *
   * @ORM\Column(name="depart_collab_le", type="date", length=255, nullable=true)
   */
  private $departCollabLe;


  /**
   * ___demande_rupture_cdd.ruptAnt
   *
   * @var string
   *
   * @ORM\Column(name="rupture_anticipe", type="string", length=255, nullable=true)
   */
  private $ruptureAnticipe;

  /**
   * ___demande_rupture_cdd.embSalonLe
   *
   * @var string
   *
   * @ORM\Column(name="emb_salon_le", type="date", length=255, nullable=true)
   */
  private $embSalonLe;


  /**
   * ___demande_rupture_cdd.departPrevuLe
   *
   * @var string
   *
   * @ORM\Column(name="depart_prevu_le", type="date", length=255, nullable=true)
   */
  private $departPrevuLe;

  /**
   * ___demande_rupture_cdd.departPrevuLe
   *
   * @var string
   *
   * @ORM\Column(name="depart_prevu_le2", type="date", length=255, nullable=true)
   */
  private $departPrevuLe2;

  /**
   * ___demande_rupture_cdd.pj
   *
   * @var string
   *
   * @ORM\Column(name="lettre", type="string", length=255, nullable=true)
   */
  private $lettre;


  /**
   * ___demande_rupture_cdd.collaborateur
   *
   * @var string
   *
   * @ORM\Column(name="nom_collab", type="string", length=255, nullable=true)
   */
  private $nomCollab;


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
     * Set finCddLe
     *
     * @param \DateTime $finCddLe
     *
     * @return DemandeRuptureCdd
     */
    public function setFinCddLe($finCddLe)
    {
        $this->finCddLe = $finCddLe;

        return $this;
    }

    /**
     * Get finCddLe
     *
     * @return \DateTime
     */
    public function getFinCddLe()
    {
        return $this->finCddLe;
    }

    /**
     * Set retourCollabLe
     *
     * @param \DateTime $retourCollabLe
     *
     * @return DemandeRuptureCdd
     */
    public function setRetourCollabLe($retourCollabLe)
    {
        $this->retourCollabLe = $retourCollabLe;

        return $this;
    }

    /**
     * Get retourCollabLe
     *
     * @return \DateTime
     */
    public function getRetourCollabLe()
    {
        return $this->retourCollabLe;
    }

    /**
     * Set finCddLe2
     *
     * @param \DateTime $finCddLe2
     *
     * @return DemandeRuptureCdd
     */
    public function setFinCddLe2($finCddLe2)
    {
        $this->finCddLe2 = $finCddLe2;

        return $this;
    }

    /**
     * Get finCddLe2
     *
     * @return \DateTime
     */
    public function getFinCddLe2()
    {
        return $this->finCddLe2;
    }

    /**
     * Set departCollabLe
     *
     * @param \DateTime $departCollabLe
     *
     * @return DemandeRuptureCdd
     */
    public function setDepartCollabLe($departCollabLe)
    {
        $this->departCollabLe = $departCollabLe;

        return $this;
    }

    /**
     * Get departCollabLe
     *
     * @return \DateTime
     */
    public function getDepartCollabLe()
    {
        return $this->departCollabLe;
    }

    /**
     * Set ruptureAnticipe
     *
     * @param string $ruptureAnticipe
     *
     * @return DemandeRuptureCdd
     */
    public function setRuptureAnticipe($ruptureAnticipe)
    {
        $this->ruptureAnticipe = $ruptureAnticipe;

        return $this;
    }

    /**
     * Get ruptureAnticipe
     *
     * @return string
     */
    public function getRuptureAnticipe()
    {
        return $this->ruptureAnticipe;
    }

    /**
     * Set embSalonLe
     *
     * @param \DateTime $embSalonLe
     *
     * @return DemandeRuptureCdd
     */
    public function setEmbSalonLe($embSalonLe)
    {
        $this->embSalonLe = $embSalonLe;

        return $this;
    }

    /**
     * Get embSalonLe
     *
     * @return \DateTime
     */
    public function getEmbSalonLe()
    {
        return $this->embSalonLe;
    }

    /**
     * Set departPrevuLe
     *
     * @param \DateTime $departPrevuLe
     *
     * @return DemandeRuptureCdd
     */
    public function setDepartPrevuLe($departPrevuLe)
    {
        $this->departPrevuLe = $departPrevuLe;

        return $this;
    }

    /**
     * Get departPrevuLe
     *
     * @return \DateTime
     */
    public function getDepartPrevuLe()
    {
        return $this->departPrevuLe;
    }

    /**
     * Set departPrevuLe2
     *
     * @param \DateTime $departPrevuLe2
     *
     * @return DemandeRuptureCdd
     */
    public function setDepartPrevuLe2($departPrevuLe2)
    {
        $this->departPrevuLe2 = $departPrevuLe2;

        return $this;
    }

    /**
     * Get departPrevuLe2
     *
     * @return \DateTime
     */
    public function getDepartPrevuLe2()
    {
        return $this->departPrevuLe2;
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
