<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
     * @var int
     *
     * @ORM\Column(name="salon_id", type="integer", nullable=true)
     */
    private $idSalon;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        $this->setLastLogin(new \DateTime());

 }
    /**
     * Set idSalon
     *
     * @param integer $idSalon
     *
     * @return User
     */
    public function setIdSalon($idSalon)
    {
        $this->idSalon = $idSalon;

        return $this;
    }

    /**
     * Get idSalon
     *
     * @return integer
     */
    public function getIdSalon()
    {
        return $this->idSalon;
    }
}
