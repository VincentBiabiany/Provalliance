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
    protected $nameDemande ='DemandeAttestationSalaire';
    protected $typeForm ='Demande d\'attestation salaire';
    protected $subject ='connu';
    protected $service ='paie';
    protected $nomDoc = 'attestation_salaire';

    /**
     * ___demande_attestation_salaire.collaborateur
     *
     * @var int
     *
     * @ORM\Column(name="matricule", type="string")
     */
    private $matricule;


    /**
     * ___demande_attestation_salaire.etat
     *
     * @var string
     *
     * @ORM\Column(name="etat", type="string")
     */
    private $etat;

    /**
     * ___demande_attestation_salaire.motif
     *
     * @var string
     *
     * @ORM\Column(name="motif", type="string")
     */
    private $motif;

    /**
     * ___demande_attestation_salaire.dateDernierJour
     *
     * @var string
     *
     * @ORM\Column(name="date_dernier_jour", type="date")
     */
    private $dateDernierJour;

    /**
     * ___demande_attestation_salaire.dateReprise
     *
     * @var string
     *
     * @ORM\Column(name="date_reprise", type="date")
     */
    private $dateReprise;


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
     * @param string $matricule
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
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set etat
     *
     * @param string $etat
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
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
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
