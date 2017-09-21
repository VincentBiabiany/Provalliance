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
     * @ORM\Column(name="personnel_id", type="integer", nullable=true)
     */
    private $idPersonnel;

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
     * Set idPersonnel
     *
     * @param integer idPersonnel
     *
     * @return User
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
