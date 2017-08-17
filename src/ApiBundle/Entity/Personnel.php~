<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnel
 *
 * @ORM\Table(name="personnel", indexes={@ORM\Index(name="fk_personnel_adresse1_idx", columns={"adresse_id"})})
 * @ORM\Entity
 */
class Personnel
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
     * @ORM\Column(name="prenom", type="string", length=45, nullable=true)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_embauche", type="datetime", nullable=true)
     */
    private $dateEmbauche;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_contrat", type="datetime", nullable=true)
     */
    private $dateFinContrat;

    /**
     * @var string
     *
     * @ORM\Column(name="type_contrat", type="string", length=45, nullable=true)
     */
    private $typeContrat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    private $sexe;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Salon", inversedBy="personnel")
     * @ORM\JoinTable(name="personnel_has_salon",
     *   joinColumns={
     *     @ORM\JoinColumn(name="personnel_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="salon_id", referencedColumnName="id")
     *   }
     * )
     */
    private $salon;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salon = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

