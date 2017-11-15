<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;

/**
 * AppBundle\Entity\DemandePromesseEmbauche
 *
 * @ORM\Table(name="demande_promesse_embauche")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandePromesseEmbaucheRepository")
 */
class DemandePromesseEmbauche extends DemandeForm
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
     * @var string
     *
     * @ORM\Column(name="contrat", type="string", nullable=false)
     */
    private $contrat;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", nullable=false)
     */
    private $poste;

    /**
     * @var string
     *
     * @ORM\Column(name="n", type="string", nullable=false)
     */
    private $n;

    /**
     * @var string
     *
     * @ORM\Column(name="e", type="string", nullable=false)
     */
    private $e;

    /**
     * @var string
     *
     * @ORM\Column(name="salaire", type="string", nullable=false)
     */
    private $salaire;

    /**
     * @var string
     *
     * @ORM\Column(name="temps", type="string", nullable=false)
     */
    private $temps;

      /**
     * @var string
     *
     * @ORM\Column(name="date_embauche", type="date", length=255)
     */
    private $dateEmbauche;
    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer")
     */
    protected $matricule;

    protected $nameDemande ='DemandePromesseEmbauche';
    protected $typeForm ='Demande de promesse d\'embauche';
    protected $subject ='connu';
    protected $service ='juridique';


    /**
     * Set contrat
     *
     * @param string $contrat
     *
     * @return DemandePromesseEmbauche
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return string
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * Set poste
     *
     * @param string $poste
     *
     * @return DemandePromesseEmbauche
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }
    /**
     * Set n
     *
     * @param string $n
     *
     * @return DemandePromesseEmbauche
     */
    public function setN($n)
    {
        $this->n = $n;

        return $this;
    }

    /**
     * Get n
     *
     * @return string
     */
    public function getN()
    {
        return $this->n;
    }
    /**
     * Set e
     *
     * @param string $e
     *
     * @return DemandePromesseEmbauche
     */
    public function setE($e)
    {
        $this->e = $e;

        return $this;
    }

    /**
     * Get e
     *
     * @return string
     */
    public function getE()
    {
        return $this->e;
    }

    /**
     * Set salaire
     *
     * @param string $salaire
     *
     * @return DemandePromesseEmbauche
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * Get salaire
     *
     * @return string
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set temps
     *
     * @param string $temps
     *
     * @return DemandePromesseEmbauche
     */
    public function setTemps($temps)
    {
        $this->temps = $temps;

        return $this;
    }

    /**
     * Get temps
     *
     * @return string
     */
    public function getTemps()
    {
        return $this->temps;
    }

    /**
     * Set dateEmbauche
     *
     * @param \DateTime $dateEmbauche
     *
     * @return DemandePromesseEmbauche
     */
    public function setDateEmbauche($dateEmbauche)
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * Get dateEmbauche
     *
     * @return \DateTime
     */
    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }


    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return DemandePromesseEmbauche
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
     * Get nameDemande
     *
     * @return integer
     */
    public function getNameDemande()
    {
        return $this->nameDemande;
    }

    /**
     * Get typeForm
     *
     * @return integer
     */
    public function getTypeForm()
    {
        return $this->typeForm;
    }
    /**
     * Get service
     *
     * @return integer
     */
    public function getService()
    {
        return $this->service;
    }


    /**
     * Get subject
     *
     * @return integer
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
