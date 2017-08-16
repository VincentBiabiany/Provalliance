<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="adresse", indexes={@ORM\Index(name="fk_adresse_pays1_idx", columns={"pays_id"})})
 * @ORM\Entity
 */
class Adresse
{
    /**
     * @var string
     *
     * @ORM\Column(name="rue", type="string", length=45, nullable=true)
     */
    private $rue;

    /**
     * @var integer
     *
     * @ORM\Column(name="cp", type="integer", nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=45, nullable=true)
     */
    private $ville;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone1", type="integer", nullable=true)
     */
    private $telephone1;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone2", type="integer", nullable=true)
     */
    private $telephone2;

    /**
     * @var integer
     *
     * @ORM\Column(name="fax", type="integer", nullable=true)
     */
    private $fax;

    /**
     * @var integer
     *
     * @ORM\Column(name="portable", type="integer", nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ApiBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pays_id", referencedColumnName="id")
     * })
     */
    private $pays;


}

