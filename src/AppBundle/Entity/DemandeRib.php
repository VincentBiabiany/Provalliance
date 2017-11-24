<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandeRib
 *
 * @ORM\Table(name="demande_rib")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeRibRepository")
 */
class DemandeRib extends DemandeForm
{
    protected $nameDemande ='DemandeRib';
    protected $typeForm ='Demande rib';
    protected $subject ='connu';
    protected $service ='paie';
    protected $nomDoc = 'rib';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * ___demande_rib.matricule
     *
     * @var int
     *
     * @ORM\Column(name="matricule", type="string")
     */
    protected $matricule;


    /**
     * ___demande_rib.rib
     *
     * @var array
     *
     * @ORM\Column(name="rib", type="array", nullable=true)
     */
    private $rib;


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
     * @return DemandeRib
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
     * Set rib
     *
     * @param array $rib
     *
     * @return DemandeRib
     */
    public function setRib($rib)
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * Get rib
     *
     * @return array
     */
    public function getRib()
    {
        return $this->rib;
    }
}
