<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\DemandeSoldeToutCompte
 *
 * @ORM\Table(name="demande_solde_tout_compte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeSoldeToutCompteRepository")
 */
class DemandeSoldeToutCompte extends DemandeForm
{
    protected $nameDemande ='DemandeSoldeToutCompte';
    protected $typeForm ='Demande solde tout compte';
    protected $subject ='connu';
    protected $service ='paie';
    protected $nomDoc = 'solde_tout_compte';


    /**
     * ___demande_solde_tout_compte.matricule
     *
     * @var int
     *
     * @ORM\Column(name="matricule", type="string")
     */
    private $matricule;

    /**
     * ___demande_solde_tout_compte.adresse
     *
     * @var string
     *
     * @ORM\Column(name="adresse", type="string")
     */
    private $adresse;

    /**
     * ___demande_solde_tout_compte.dateSortie
     *
     * @var string
     *
     * @ORM\Column(name="date_sortie", type="date")
     */
    private $dateSortie;

    /**
     * ___demande_solde_tout_compte.dateDernierJour
     *
     * @var string
     *
     * @ORM\Column(name="date_dernier_jour", type="date")
     */
    private $dateDernierJour;

    /**
     * ___demande_solde_tout_compte.motif
     *
     * @var string
     *
     * @ORM\Column(name="motif", type="string")
     */
    private $motif;

    /**
     * ___demande_solde_tout_compte.typeAbsence
     *
     * @var array
     *
     * @ORM\Column(name="type_absence", type="array")
     */
    private $typeAbsence;

    /**
     * ___demande_solde_tout_compte.primes
     *
     * @var array
     *
     * @ORM\Column(name="primes", type="array")
     */
    private $primes;

    /**
     * ___demande_solde_tout_compte.remarques
     *
     * @var array
     *
     * @ORM\Column(name="remarques", type="array")
     */
    private $remarques;


    /**
     * ___demande_solde_tout_compte.rupture
     *
     * @var string
     *
     * @ORM\Column(name="rupture", type="string")
     */
    private $rupture;

    /**
     * ___demande_solde_tout_compte.dateDebut
     *
     */
    private $dateDebut;

    /**
     * ___demande_solde_tout_compte.dateFin
     *
     */
    private $dateFin;

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
     * @return DemandeSoldeToutCompte
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return DemandeSoldeToutCompte
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set dateSortie
     *
     * @param \DateTime $dateSortie
     *
     * @return DemandeSoldeToutCompte
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateSortie
     *
     * @return \DateTime
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * Set dateDernierJour
     *
     * @param \DateTime $dateDernierJour
     *
     * @return DemandeSoldeToutCompte
     */
    public function setDateDernierJour($dateDernierJour)
    {
        $this->dateDernierJour = $dateDernierJour;

        return $this;
    }

    /**
     * Get dateDernierJour
     *
     * @return \DateTime
     */
    public function getDateDernierJour()
    {
        return $this->dateDernierJour;
    }

    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return DemandeSoldeToutCompte
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set typeAbsence
     *
     * @param array $typeAbsence
     *
     * @return DemandeSoldeToutCompte
     */
    public function setTypeAbsence($typeAbsence)
    {
        $this->typeAbsence = $typeAbsence;

        return $this;
    }

    /**
     * Get typeAbsence
     *
     * @return array
     */
    public function getTypeAbsence()
    {
        return $this->typeAbsence;
    }

    /**
     * Set primes
     *
     * @param array $primes
     *
     * @return DemandeSoldeToutCompte
     */
    public function setPrimes($primes)
    {
        $this->primes = $primes;

        return $this;
    }

    /**
     * Get primes
     *
     * @return array
     */
    public function getPrimes()
    {
        return $this->primes;
    }

    /**
     * Set remarques
     *
     * @param array $remarques
     *
     * @return DemandeSoldeToutCompte
     */
    public function setRemarques($remarques)
    {
        $this->remarques = $remarques;

        return $this;
    }

    /**
     * Get remarques
     *
     * @return array
     */
    public function getRemarques()
    {
        return $this->remarques;
    }

    /**
     * Set rupture
     *
     * @param string $rupture
     *
     * @return DemandeSoldeToutCompte
     */
    public function setRupture($rupture)
    {
        $this->rupture = $rupture;

        return $this;
    }

    /**
     * Get rupture
     *
     * @return string
     */
    public function getRupture()
    {
        return $this->rupture;
    }
}
