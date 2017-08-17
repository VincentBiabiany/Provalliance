<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonnelHasProfession
 *
 * @ORM\Table(name="referentiel.personnel_has_profession", indexes={@ORM\Index(name="fk_personnel_has_profession_profession1_idx", columns={"profession_id"}), @ORM\Index(name="fk_personnel_has_profession_personnel1_idx", columns={"personnel_id"}), @ORM\Index(name="fk_personnel_has_profession_date_profession1_idx", columns={"date_profession_id"})})
 * @ORM\Entity
 */
class PersonnelHasProfession
{
    /**
     * @var \ApiBundle\Entity\DateProfession
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\DateProfession")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="date_profession_id", referencedColumnName="id")
     * })
     */
    private $dateProfession;

    /**
     * @var \ApiBundle\Entity\Personnel
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ApiBundle\Entity\Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personnel_id", referencedColumnName="id")
     * })
     */
    private $personnel;

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
     * Set dateProfession
     *
     * @param \ApiBundle\Entity\DateProfession $dateProfession
     *
     * @return PersonnelHasProfession
     */
    public function setDateProfession(\ApiBundle\Entity\DateProfession $dateProfession)
    {
        $this->dateProfession = $dateProfession;

        return $this;
    }

    /**
     * Get dateProfession
     *
     * @return \ApiBundle\Entity\DateProfession
     */
    public function getDateProfession()
    {
        return $this->dateProfession;
    }

    /**
     * Set personnel
     *
     * @param \ApiBundle\Entity\Personnel $personnel
     *
     * @return PersonnelHasProfession
     */
    public function setPersonnel(\ApiBundle\Entity\Personnel $personnel)
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

    /**
     * Set profession
     *
     * @param \ApiBundle\Entity\Profession $profession
     *
     * @return PersonnelHasProfession
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
}
