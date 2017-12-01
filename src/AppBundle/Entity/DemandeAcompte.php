<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\DemandeAcompte
 *
 * @ORM\Table(name="demande_acompte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeAcompteRepository")
 */
class DemandeAcompte extends DemandeForm
{
    protected $nameDemande ='DemandeAcompte';
    protected $typeForm ='Demande acompte';
    protected $subject ='connu';
    protected $service ='paie';
    protected $nomDoc = 'acompte';

    /**
     * ___demande_acompte.matricule
     *
     * @var int
     *
     * @ORM\Column(name="matricule", type="string")
     */
    private $matricule;


    /**
     * ___demande_acompte.montant
     *
     * @var string
     *
     * @ORM\Column(name="montant", type="string")
     */
    private $montant;


    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return DemandeAcompte
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
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
     * Get matricule
     *
     * @return integer
     */
    public function getMatricule()
    {
        return $this->matricule;
    }


    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return DemandeAcompte
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
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
