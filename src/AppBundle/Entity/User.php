<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

 /**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Admin/UserRepository")
 * @UniqueEntity(fields="usernameCanonical", errorPath="username", message="fos_user.username.already_used")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true))
 * })
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
     * @var string
     *
     */
    protected $username;

	/**
     * @var int
     *
     * @ORM\Column(name="matricule", type="string", nullable=true)
     */
    private $matricule;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation", type="datetime", nullable=true)
     */
    private $creation;
    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        $this->setLastLogin(new \DateTime());

 }
     /**
      * Set matricule
      *
      * @param string $matricule
      *
      * @return DemandeAcompte
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
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return User
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }
}
