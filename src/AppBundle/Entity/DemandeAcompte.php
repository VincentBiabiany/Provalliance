<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\DemandeAcompte
 *
 * @ORM\Table(name="webapp.demande_acompte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeAcompteRepository")
 */
class DemandeAcompte
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;   
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    
    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;
    
     /**
     * @var \ApiBundle\Entity\Personnel
     * @ORM\ManyToOne(targetEntity="\ApiBundle\Entity\Personnel", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="demandeur_id", referencedColumnName="id")
     * })
     */
    private $demandeur;

    /**
     * @var \ApiBundle\Entity\Personnel
     * @ORM\ManyToOne(targetEntity="\ApiBundle\Entity\Personnel", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personnel_id", referencedColumnName="id")
     * })
     */
    private $personnel;
    
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
     * Set nom
     *
     * @param string $nom
     *
     * @return DemandeAcompte
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return DemandeAcompte
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    } 
    
    /**
     * Set montant
     *
     * @param integer $montant
     *
     * @return DemandeAcompte
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer
     */
    public function getMontant()
    {
        return $this->montant;
    }
    
      /**
     * Set demandeur
     *
     * @param \ApiBundle\Entity\Personnel $demandeur
     *
     * @return DemandeAcompte
     */
    public function setDemandeur(\ApiBundle\Entity\Personnel $demandeur = null)
    {
        $this->personnel = $demandeur;

        return $this;
    }

    /**
     * Get demandeur
     *
     * @return \ApiBundle\Entity\Personnel
     */
    public function getDemandeur()
    {
        return $this->personnel;
    }  
    
    
    /**
     * Set personnel
     *
     * @param \ApiBundle\Entity\Personnel $personnel
     *
     * @return DemandeAcompte
     */
    public function setPersonnel(\ApiBundle\Entity\Personnel $personnel = null)
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * Get personnel
     *
     * @return \ApiBundle\Entity\Personnel
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }
    
}