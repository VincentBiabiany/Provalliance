<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"demande_form" = "DemandeForm",
 *                        "demande_embauche" = "DemandeEmbauche",
 *                        "demande_acompte" = "DemandeAcompte",
 *                        "demande_rib" = "DemandeRib",
 *                        "autre_demande" = "AutreDemande",
 *                        "demande_rupture_periode_essai" = "DemandeRupturePeriodeEssai",
 *                        "lettre_mission" = "DemandeLettreMission",
 *                        "demande_demission" = "DemandeDemission",
 *                        "demande_promesse_embauche" = "DemandePromesseEmbauche",
 *                        "rupture_cdd" = "DemandeRuptureCdd",
 *                        "conge_parental" = "DemandeCongeParental",
 *                        "demande_essai_professionnel" = "DemandeEssaiProfessionnel",
 *                        "demande_solde_tout_compte" = "DemandeSoldeToutCompte",
 *                        "demande_avenant" = "DemandeAvenant",
 *                        "demande_absences_injustifieest" = "DemandeAbsencesInjustifiees",
 *                      })
 */
abstract class DemandeForm
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
     * @ORM\Column(name="type_form", type="string", length=255, nullable=true)
     */
    private $typeForm;

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
     * Set typeForm
     *
     * @param string $typeForm
     *
     * @return DemandeForm
     */
    public function setTypeForm($typeForm)
    {
        $this->typeForm = $typeForm;

        return $this;
    }

    /**
     * Get typeForm
     *
     * @return string
     */
    public function getTypeForm()
    {
        return $this->typeForm;
    }
    /**
     * Set discr
     *
     * @param string $discr
     *
     * @return DemandeForm
     */
    public function setDiscr($discr)
    {
        $this->discr = $discr;

        return $this;
    }

    /**
     * Get discr
     *
     * @return string
     */
    public function getDiscr()
    {
        return $this->discr;
    }

}
