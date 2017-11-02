<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonnelHasSalon
 *
 * @ORM\Table(name="personnel_has_salon", indexes={@ORM\Index(name="fk_personnel_has_salon_profession1_idx", columns={"profession_id"}), @ORM\Index(name="fk_personnel_has_salon_personnel1_idx", columns={"personnel_matricule"}), @ORM\Index(name="fk_personnel_has_salon_salon1_idx", columns={"salon_sage"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\PersonnelHasSalonRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PersonnelHasSalon
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @var \ApiBundle\Entity\Personnel
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Personnel", inversedBy="matricule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personnel_matricule", referencedColumnName="matricule")
     * })
     */
    private $personnelMatricule;

    /**
     * @var \ApiBundle\Entity\Profession
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Profession")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profession_id", referencedColumnName="id")
     * })
     */
    private $profession;

    /**
     * @var \ApiBundle\Entity\Salon
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Salon", inversedBy="salon")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="salon_sage", referencedColumnName="sage")
     * })
     */
    private $salonSage;


    /**
     * @ORM\PostLoad
     */
    public function onPostLoad()
    {
        $now = (new \DateTime())->format('Y-m-d');

        if ($this->dateFin->format('Y-m-d') <= $now)
          $this->actif = 0;
        else
          $this->actif = 1;
    }



    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return PersonnelHasSalon
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
     * @return PersonnelHasSalon
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
     * Set actif
     *
     * @param boolean $actif
     *
     * @return PersonnelHasSalon
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set personnelMatricule
     *
     * @param \ApiBundle\Entity\Personnel $personnelMatricule
     *
     * @return PersonnelHasSalon
     */
    public function setPersonnelMatricule(\ApiBundle\Entity\Personnel $personnelMatricule)
    {
        $this->personnelMatricule = $personnelMatricule;

        return $this;
    }

    /**
     * Get personnelMatricule
     *
     * @return \ApiBundle\Entity\Personnel
     */
    public function getPersonnelMatricule()
    {
        return $this->personnelMatricule;
    }

    /**
     * Set profession
     *
     * @param \ApiBundle\Entity\Profession $profession
     *
     * @return PersonnelHasSalon
     */
    public function setProfession(\ApiBundle\Entity\Profession $profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return \ApiBundle\Entity\Profession
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set salonSage
     *
     * @param \ApiBundle\Entity\Salon $salonSage
     *
     * @return PersonnelHasSalon
     */
    public function setSalonSage(\ApiBundle\Entity\Salon $salonSage)
    {
        $this->salonSage = $salonSage;

        return $this;
    }

    /**
     * Get salonSage
     *
     * @return \ApiBundle\Entity\Salon
     */
    public function getSalonSage()
    {
        return $this->salonSage;
    }
}
