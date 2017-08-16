<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enseigne
 *
 * @ORM\Table(name="enseigne")
 * @ORM\Entity
 */
class Enseigne
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=45, nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_court", type="string", length=45, nullable=true)
     */
    private $libelleCourt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

