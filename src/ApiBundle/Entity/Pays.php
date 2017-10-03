<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * @ORM\Entity
 */
class Pays
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
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Langue", inversedBy="pays")
     * @ORM\JoinTable(name="pays_has_langue",
     *   joinColumns={
     *     @ORM\JoinColumn(name="pays_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="langue_id", referencedColumnName="id")
     *   }
     * )
     */
    private $langue;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->langue = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Pays
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
     * Add langue
     *
     * @param \ApiBundle\Entity\Langue $langue
     *
     * @return Pays
     */
    public function addLangue(\ApiBundle\Entity\Langue $langue)
    {
        $this->langue[] = $langue;

        return $this;
    }

    /**
     * Remove langue
     *
     * @param \ApiBundle\Entity\Langue $langue
     */
    public function removeLangue(\ApiBundle\Entity\Langue $langue)
    {
        $this->langue->removeElement($langue);
    }

    /**
     * Get langue
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangue()
    {
        return $this->langue;
    }
}
