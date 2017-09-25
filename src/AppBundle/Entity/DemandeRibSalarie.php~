<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandeRibSalarie
 *
 * @ORM\Table(name="demande_rib_salarie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeRibSalarieRepository")
 */
class DemandeRibSalarie extends DemandeForm
{
    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $rib;

    /**
     * @var int
     *
     * @ORM\Column(name="personnel_id", type="integer")
     */
    protected $idPersonnel;

    /**
     * Set rib
     *
     * @param integer $rib
     *
     * @return RibSalarie
     */
    public function setRib($rib)
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * Get rib
     *
     * @return integer
     */
    public function getRib()
    {
        return $this->rib;
    }

    /**
     * Set personnel
     *
     * @param integer $personnel
     *
     * @return RibSalarie
     */
    public function setPersonnel($personnel)
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * Get personnel
     *
     * @return integer
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }

    /**
     * Set idPersonnel
     *
     * @param integer $idPersonnel
     *
     * @return DemandeRibSalarie
     */
    public function setIdPersonnel($idPersonnel)
    {
        $this->idPersonnel = $idPersonnel;

        return $this;
    }

    /**
     * Get idPersonnel
     *
     * @return integer
     */
    public function getIdPersonnel()
    {
        return $this->idPersonnel;
    }
}
