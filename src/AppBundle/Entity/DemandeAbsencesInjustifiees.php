<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;


/**
 * AppBundle\Entity\DemandeAbsencesInjustifiees
 *
 * @ORM\Table(name="demande_absences_injustifiees")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeAbsencesInjustifieesRepository")
 */
class DemandeAbsencesInjustifiees extends DemandeForm
{
  protected $nameDemande = 'DemandeAbsencesInjustifiees';
  protected $typeForm = 'Demande d\'absences injustifiees';
  protected $subject = 'connu';
  protected $service = 'juridique';
  protected $nomDoc = 'acompte';


  /**
   * ___demande_absences.collaborateur
   *
   * @var int
   *
   * @ORM\Column(name="matricule", type="integer")
   */
  protected $matricule;

  /**
   * ___demande_absences.raison
   *
   * @var string
   *
   * @ORM\Column(name="raison", type="string", length=255, nullable=true)
   */
  private $raison;


  /**
   * ___demande_absences.retards
   *
   * @var array
   *
   * @ORM\Column(name="retards", type="array", nullable=true)
   */
  private $retards;


  /**
   * ___demande_absences.absLes
   *
   * @var array
   *
   * @ORM\Column(name="absences", type="array", nullable=true)
   */
  private $absences;

  /**
   * ___demande_absences.date
   *
   * @var string
   *
   * @ORM\Column(name="date_debut", type="date", length=255, nullable=true)
   */
  private $dateDebut;

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
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return DemandeAbsencesInjustifiees
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
     * @return DemandeAbsencesInjustifiees
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
     * Set retards
     *
     * @param array $retards
     *
     * @return DemandeAbsencesInjustifiees
     */
    public function setRetards($retards)
    {
        $this->retards = $retards;

        return $this;
    }

    /**
     * Get retards
     *
     * @return array
     */
    public function getRetards()
    {
        return $this->retards;
    }

    /**
     * Set absences
     *
     * @param array $absences
     *
     * @return DemandeAbsencesInjustifiees
     */
    public function setAbsences($absences)
    {
        $this->absences = $absences;

        return $this;
    }

    /**
     * Get absences
     *
     * @return array
     */
    public function getAbsences()
    {
        return $this->absences;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return DemandeAbsencesInjustifiees
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
}
