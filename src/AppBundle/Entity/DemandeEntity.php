<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"demande_entity" = "DemandeEntity", "demande_simple" = "DemandeSimple", "demande_complexe" = "DemandeComplexe"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeEntityRepository")
 * @ORM\HasLifecycleCallbacks()
 */

abstract class DemandeEntity
{
  const statut_REJETE  = 0;
  const statut_EN_COURS = 1;
  const statut_TRAITE  = 2;
  const statut_ASIGNE  = 3;
  const statut_AVALIDE  = 4;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \AppBundle\Entity\DemandeForm
     *
     * @ORM\OneToOne(targetEntity="DemandeForm", cascade={"persist"})
     *
     */
    protected $demandeform;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_envoie", type="datetime", nullable=true)
     */
    private $dateEnvoi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_traitement", type="datetime", nullable=true)
     */
    private $dateTraitement;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=45, nullable=true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=45, nullable=true)
     */
    private $service;

    /**
     * @var int
     *
     * @ORM\Column(name="salon_id", type="integer", length=45, nullable=true)
     */
    private $idSalon;

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        $this->setDateEnvoi(new \DateTime());
        $this->setstatut(self::statut_EN_COURS);
        $this->setDateTraitement(new \DateTime());
    }

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
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return Demande
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * Set dateTraitement
     *
     * @param \DateTime $dateTraitement
     *
     * @return Demande
     */
    public function setDateTraitement($dateTraitement)
    {
        $this->dateTraitement = $dateTraitement;

        return $this;
    }

    /**
     * Get dateTraitement
     *
     * @return \DateTime
     */
    public function getDateTraitement()
    {
        return $this->dateTraitement;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Demande
     */
    public function setstatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getstatut()
    {
        return $this->statut;
    }

    /**
     * Set demandeform
     *
     * @param \AppBundle\Entity\DemandeForm $demandeform
     *
     * @return Demande
     */
    public function setDemandeform(\AppBundle\Entity\DemandeForm $demandeform = null)
    {
        $this->demandeform = $demandeform;

        return $this;
    }

    /**
     * Get demandeform
     *
     * @return \AppBundle\Entity\DemandeForm
     */
    public function getDemandeform()
    {
        return $this->demandeform;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Demande
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set idSalon
     *
     * @param integer $idSalon
     *
     * @return Demande
     */
    public function setIdSalon($idSalon)
    {
        $this->idSalon = $idSalon;

        return $this;
    }

    /**
     * Get idSalon
     *
     * @return integer
     */
    public function getIdSalon()
    {
        return $this->idSalon;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Demande
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }
  }
