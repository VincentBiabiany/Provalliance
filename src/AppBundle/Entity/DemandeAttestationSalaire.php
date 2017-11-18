<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\DemandeAttestationSalaire
 *
 * @ORM\Table(name="demande_attestation_salaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeAttestationSalaireRepository")
 */
class DemandeAttestationSalaire extends DemandeForm
{
    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string")
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="string")
     */
    private $motif;

    /**
     * @var string
     *
     * @ORM\Column(name="date_dernier_jour", type="date")
     */
    private $dateDernierJour;
    /**
     * @var string
     *
     * @ORM\Column(name="date_reprise", type="date")
     */
    private $dateReprise;

    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer")
     */
    private $matricule;

    protected $nameDemande ='DemandeAttestationSalaire';
    protected $typeForm ='Demande d\'attestation salaire';
    protected $subject ='connu';
    protected $service ='paie';

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return DemandeAttestationSalaire
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return DemandeAttestationSalaire
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
     * Set motif
     *
     * @param string $motif
     *
     * @return DemandeAttestationSalaire
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set dateDernierJour
     *
     * @param \DateTime $dateDernierJour
     *
     * @return DemandeAttestationSalaire
     */
    public function setDateDernierJour($dateDernierJour)
    {
        $this->dateDernierJour = $dateDernierJour;

        return $this;
    }

    /**
     * Get dateDernierJour
     *
     * @return \DateTime
     */
    public function getDateDernierJour()
    {
        return $this->dateDernierJour;
    }

    /**
     * Set dateReprise
     *
     * @param \DateTime $dateReprise
     *
     * @return DemandeAttestationSalaire
     */
    public function setDateReprise($dateReprise)
    {
        $this->dateReprise = $dateReprise;

        return $this;
    }

    /**
     * Get dateReprise
     *
     * @return \DateTime
     */
    public function getDateReprise()
    {
        return $this->dateReprise;
    }
}
