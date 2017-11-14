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
class DemandeLettreMission extends DemandeForm
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

    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return DemandeLettreMission
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return integer
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set sage
     *
     * @param integer $sage
     *
     * @return DemandeLettreMission
     */
    public function setSage($sage)
    {
        $this->sage = $sage;

        return $this;
    }

    /**
     * Get sage
     *
     * @return integer
     */
    public function getSage()
    {
        return $this->sage;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return DemandeLettreMission
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return DemandeLettreMission
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set raison
     *
     * @param string $raison
     *
     * @return DemandeLettreMission
     */
    public function setRaison($raison)
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * Get raison
     *
     * @return string
     */
    public function getRaison()
    {
        return $this->raison;
    }

    /**
     * Set tempsPartiel
     *
     * @param array $tempsPartiel
     *
     * @return DemandeLettreMission
     */
    public function setTempsPartiel($tempsPartiel)
    {
        $this->tempsPartiel = $tempsPartiel;

        return $this;
    }

    /**
     * Get tempsPartiel
     *
     * @return array
     */
    public function getTempsPartiel()
    {
        return $this->tempsPartiel;
    }
}
