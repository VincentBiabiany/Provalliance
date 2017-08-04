<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profession
 *
 * @ORM\Table(name="profession")
 * @ORM\Entity
 */
class Profession
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Personnel", mappedBy="profession", cascade={"persist"})
     */
    private $personnel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnel = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Profession
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add personnel
     *
     * @param \ApiBundle\Entity\Personnel $personnel
     *
     * @return Profession
     */
    public function addPersonnel(\ApiBundle\Entity\Personnel $personnel)
    {
        $this->personnel[] = $personnel;

        return $this;
    }

    /**
     * Remove personnel
     *
     * @param \ApiBundle\Entity\Personnel $personnel
     */
    public function removePersonnel(\ApiBundle\Entity\Personnel $personnel)
    {
        $this->personnel->removeElement($personnel);
    }

    /**
     * Get personnel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }
}
