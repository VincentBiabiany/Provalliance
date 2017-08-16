<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salon
 *
 * @ORM\Table(name="salon", indexes={@ORM\Index(name="fk_salon_adresse1_idx", columns={"adresse_id"}), @ORM\Index(name="fk_salon_groupe1_idx", columns={"groupe_id"}), @ORM\Index(name="fk_salon_enseigne1_idx", columns={"enseigne_id"})})
 * @ORM\Entity
 */
class Salon
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
     * @ORM\Column(name="code_interne", type="string", length=45, nullable=true)
     */
    private $codeInterne;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=45, nullable=true)
     */
    private $siret;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fermeture", type="datetime", nullable=true)
     */
    private $dateFermeture;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=45, nullable=true)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="langue_defaut", type="string", length=45, nullable=true)
     */
    private $langueDefaut;

    /**
     * @var string
     *
     * @ORM\Column(name="marlix", type="string", length=20, nullable=true)
     */
    private $marlix;

    /**
     * @var integer
     *
     * @ORM\Column(name="sage_paie", type="integer", nullable=true)
     */
    private $sagePaie;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ApiBundle\Entity\Adresse
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adresse_id", referencedColumnName="id")
     * })
     */
    private $adresse;

    /**
     * @var \ApiBundle\Entity\Enseigne
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Enseigne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enseigne_id", referencedColumnName="id")
     * })
     */
    private $enseigne;

    /**
     * @var \ApiBundle\Entity\Groupe
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Groupe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groupe_id", referencedColumnName="id")
     * })
     */
    private $groupe;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Personnel", mappedBy="salon")
     */
    private $personnel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnel = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

