<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\AccountRepository")
 */

class Account
{

    /**
     * @var int
     *
     * @ORM\Column(name="personnel_matricule", type="integer")
     */
    private $idPersonnel;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Account
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set idPersonnel
     *
     * @param integer $idPersonnel
     *
     * @return Account
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
