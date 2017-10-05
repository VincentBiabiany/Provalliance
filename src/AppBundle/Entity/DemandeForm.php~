<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"demande_form" = "DemandeForm","demande_embauche" = "DemandeEmbauche", "demande_acompte" = "DemandeAcompte", "demande_rib_salarie" = "DemandeRibSalarie", "autre_demande" = "AutreDemande"})
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
}
