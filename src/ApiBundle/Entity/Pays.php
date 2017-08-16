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

}

