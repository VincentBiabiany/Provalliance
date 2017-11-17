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
     * @ORM\Column(name="dem", type="array", nullable=true)
     */
    private $dem;

    /**
     * @var string
     *
     * @ORM\Column(name="clause", type="string", nullable=false)
     */
    private $clause;

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

    protected $nameDemande ='DemandeDemission';
    protected $typeForm ='Demande de démission';
    protected $subject ='connu';
    protected $service ='juridique';

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
     * Set matricule
     *
     * @param integer $matricule
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
