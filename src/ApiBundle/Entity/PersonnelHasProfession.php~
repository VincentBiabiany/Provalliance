<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonnelHasProfession
 *
 * @ORM\Table(name="personnel_has_profession", indexes={@ORM\Index(name="fk_personnel_has_profession_profession1_idx", columns={"profession_id"}), @ORM\Index(name="fk_personnel_has_profession_personnel1_idx", columns={"personnel_id"}), @ORM\Index(name="fk_personnel_has_profession_date_profession1_idx", columns={"date_profession_id"})})
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


}

