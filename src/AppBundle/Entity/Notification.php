<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\Notification")
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="demande", type="string", nullable=false)
     */
    private $demande;

    /**
     * @var array
     *
     * @ORM\Column(name="valeur", type="array", nullable=false)
     */
    private $valeur;

    /**
     * Set valeur
     *
     * @param array $valeur
     *
     * @return Notification
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return array
     */
    public function getValeur()
    {
        return $this->valeur;
    }


    /**
     * Set demande
     *
     * @param string $demande
     *
     * @return Notification
     */
    public function setDemande($demande)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return string
     */
    public function getDemande()
    {
        return $this->demande;
    }

}
