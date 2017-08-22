<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandeAcompte
 *
 * @ORM\Table(name="webapp.demande_acompte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeAcompteRepository")
 */
class DemandeAcompte extends DemandeForm
{
    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="personnel_id", type="integer")
     */
    private $personnel;

    /**
     * Set montant
     *
     * @param integer $montant
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
     * @return integer
     */
    public function getMontant()
    {
        return $this->montant;
    }   

    /**
     * Set personnel
     *
     * @param integer $personnel
     *
     * @return DemandeAcompte
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
}
