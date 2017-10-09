<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeEntity;

/**
 * DemandeEmbauche
 *
 * @ORM\Table(name="demande_complexe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeComplexeRepository")
 */
class DemandeComplexe extends DemandeEntity
{
  /**
   * @var string
   *
   * @ORM\Column(name="doc_service", type="string", length=255)
   */
  protected $docService;

  /**
   * @var string
   *
   * @ORM\Column(name="doc_salon", type="string", length=255)
   */
  protected $docSalon;

    /**
     * Set docService
     *
     * @param string $docService
     *
     * @return DemandeComplexe
     */
    public function setDocService($docService)
    {
        $this->docService = $docService;

        return $this;
    }

    /**
     * Get docService
     *
     * @return string
     */
    public function getDocService()
    {
        return $this->docService;
    }

    /**
     * Set docSalon
     *
     * @param string $docSalon
     *
     * @return DemandeComplexe
     */
    public function setDocSalon($docSalon)
    {
        $this->docSalon = $docSalon;

        return $this;
    }

    /**
     * Get docSalon
     *
     * @return string
     */
    public function getDocSalon()
    {
        return $this->docSalon;
    }
}
