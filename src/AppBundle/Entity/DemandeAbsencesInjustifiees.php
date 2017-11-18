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

  /**
   * @var array
   *
   * @ORM\Column(name="retards", type="array", nullable=true)
   */
  private $retards;


  /**
   * @var array
   *
   * @ORM\Column(name="absences", type="array", nullable=true)
   */
  private $absences;

  /**
   * @var string
   *
   * @ORM\Column(name="date_debut", type="date", length=255, nullable=true)
   */
  private $dateDebut;

  /**
   * @var string
   *
   * @ORM\Column(name="raison", type="string", length=255, nullable=true)
   */
  private $raison;

  /**
   * @var int
   *
   * @ORM\Column(name="matricule", type="integer")
   */
  protected $matricule;


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


}
