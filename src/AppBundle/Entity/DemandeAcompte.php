<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;
use Symfony\Component\Validator\Constraints as Assert;

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
    private $idPersonnel;


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
     * Set idPersonnel
     *
     * @param integer $idPersonnel
     *
     * @return DemandeAcompte
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
