<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * DemandeEmbauche
 *
 * @ORM\Table(name="demande_lettre_mission")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeEmbaucheRepository")
 */
class DemandeEmbauche extends DemandeForm
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer")
     */
    private $matricule;

    /**
     * @var int
     *
     * @ORM\Column(name="sage", type="integer")
     */
    private $sage;

    /**
     * @var string
     *
     * @ORM\Column(name="date_debut", type="date", length=255)
     */
    private $dateDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="date_fin", type="date", length=255)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="raison", type="string", length=255,  nullable=true)
     */
    private $raison;

    /**
     * @var array
     *
     * @ORM\Column(name="temps_partiel", type="array",  nullable=true)
     */
    private $tempsPartiel;


    public function __construct()
    {
      $this->tempsPartiel = ['lundi'=>0, 'mardi'=>0,'mercredi'=>0, 'jeudi'=>0,'vendredi'=>0,'samedi'=>0,'total'=>0];
    }


}
