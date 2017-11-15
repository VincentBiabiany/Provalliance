<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandeRupturePeriodeEssai
 *
 * @ORM\Table(name="demande_rupture_periode_essai")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeRupturePeriodeEssaiRepository")
 */
class DemandeRupturePeriodeEssai extends DemandeForm
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="contrat", type="array", nullable=true)
     */
    private $contrat;

    /**
     * @var string
     *
     * @ORM\Column(name="moyen", type="string", nullable=false)
     */
    private $moyen;

      /**
     * @var string
     *
     * @ORM\Column(name="date", type="date", length=255)
     */
    private $date;
    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer")
     */
    protected $matricule;

    protected $nameDemande ='DemandeRupturePeriodeEssai';
    protected $typeForm ='Demande rupture periode d\'essai';
    protected $subject ='connu';
    protected $service ='juridique';

    /**
     * Set contrat
     *
     * @param array $contrat
     *
     * @return DemandeRupturePeriodeEssai
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return array
     */
    public function getContrat()
    {
        return $this->contrat;
    }
    /**
     * Set moyen
     *
     * @param string $moyen
     *
     * @return DemandeRupturePeriodeEssai
     */
    public function setMoyen($moyen)
    {
        $this->moyen = $moyen;

        return $this;
    }

    /**
     * Get moyen
     *
     * @return string
     */
    public function getMoyen()
    {
        return $this->moyen;
    }
    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DemandeRupturePeriodeEssai
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return DemandeRupturePeriodeEssai
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
}
