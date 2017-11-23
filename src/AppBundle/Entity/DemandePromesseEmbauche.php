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
    protected $nameDemande ='DemandePromesseEmbauche';
    protected $typeForm ='Demande de promesse d\'embauche';
    protected $subject ='connu';
    protected $service ='juridique';
    protected $nomDoc = 'promesse_embauche';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * ___demande_promesse_embauche.collaborateur
     *
     * @var int
     *
     * @ORM\Column(name="matricule", type="string")
     */
    protected $matricule;


    /**
     * ___demande_promesse_embauche.contrat
     *
     * @var string
     *
     * @ORM\Column(name="contrat", type="string", nullable=false)
     */
    private $contrat;


    /**
     * ___demande_promesse_embauche.poste
     *
     * @var string
     *
     * @ORM\Column(name="poste", type="string", nullable=false)
     */
    private $poste;

    /**
     * ___demande_promesse_embauche.niveau
     *
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", nullable=false)
     */
    private $niveau;

    /**
     * ___demande_promesse_embauche.echelon
     *
     * @var string
     *
     * @ORM\Column(name="echelon", type="string", nullable=false)
     */
    private $echelon;

    /**
     * ___demande_promesse_embauche.salaire
     *
     * @var string
     *
     * @ORM\Column(name="salaire", type="string", nullable=false)
     */
    private $salaire;

    /**
     * ___demande_promesse_embauche.temps
     *
     * @var string
     *
     * @ORM\Column(name="temps", type="string", nullable=false)
     */
    private $temps;

    /**
     * ___demande_promesse_embauche.dateEmbauche
     *
     * @var string
     *
     * @ORM\Column(name="date_embauche", type="date", length=255)
     */
    private $dateEmbauche;


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
     * Get nomDoc
     *
     * @return integer
     */
    public function getNomDoc()
    {
        return $this->nomDoc;
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

    /**
     * Set matricule
     *
     * @param string $matricule
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
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

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
     * Set niveau
     *
     * @param string $niveau
     *
     * @return DemandePromesseEmbauche
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set echelon
     *
     * @param string $echelon
     *
     * @return DemandePromesseEmbauche
     */
    public function setEchelon($echelon)
    {
        $this->echelon = $echelon;

        return $this;
    }

    /**
     * Get echelon
     *
     * @return string
     */
    public function getEchelon()
    {
        return $this->echelon;
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
}
