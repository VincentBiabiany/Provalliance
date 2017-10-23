<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonnelHasSalon
 *
 * @ORM\Table(name="personnel_has_salon", indexes={@ORM\Index(name="fk_personnel_has_salon_profession1_idx", columns={"profession_id"}), @ORM\Index(name="fk_personnel_has_salon_personnel1_idx", columns={"personnel_matricule"}), @ORM\Index(name="fk_personnel_has_salon_salon1_idx", columns={"salon_sage"})})
 * @ORM\Entity
 */
class PersonnelHasSalon
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personnel_matricule", referencedColumnName="matricule")
     * })
     */
    private $personnelMatricule;

    /**
     * @var \ApiBundle\Entity\Profession
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\Profession")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profession_id", referencedColumnName="id")
     * })
     */
    private $profession;

    /**
     * @var \ApiBundle\Entity\Salon
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\Salon")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="salon_sage", referencedColumnName="sage")
     * })
     */
    private $salonSage;



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