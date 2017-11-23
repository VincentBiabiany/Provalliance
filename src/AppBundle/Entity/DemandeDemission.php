<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandeDemission
 *
 * @ORM\Table(name="demande_demission")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeDemissionRepository")
 */
class DemandeDemission extends DemandeForm
{
    protected $nameDemande ='DemandeDemission';
    protected $typeForm ='Demande de démission';
    protected $subject ='connu';
    protected $service ='juridique';
    protected $nomDoc = 'demission';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * ___demande_demission.collab
     *
     * @var int
     *
     * @ORM\Column(name="matricule", type="string")
     */
    protected $matricule;

    /**
     * ___demande_demission.clause
     *
     * @var string
     *
     * @ORM\Column(name="clause", type="string", nullable=false)
     */
    private $clause;


    /**
     * ___demande_demission.date
     *
     * @var string
     *
     * @ORM\Column(name="date", type="date", length=255)
     */
    private $date;

    /**
     * ___demande_demission.dem
     *
     * @var array
     *
     * @ORM\Column(name="dem", type="array", nullable=true)
     */
    private $dem;


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
     * @return DemandeDemission
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
     * Set clause
     *
     * @param string $clause
     *
     * @return DemandeDemission
     */
    public function setClause($clause)
    {
        $this->clause = $clause;

        return $this;
    }

    /**
     * Get clause
     *
     * @return string
     */
    public function getClause()
    {
        return $this->clause;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DemandeDemission
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
     * Set dem
     *
     * @param array $dem
     *
     * @return DemandeDemission
     */
    public function setDem($dem)
    {
        $this->dem = $dem;

        return $this;
    }

    /**
     * Get dem
     *
     * @return array
     */
    public function getDem()
    {
        return $this->dem;
    }
}
