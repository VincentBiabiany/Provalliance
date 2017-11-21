<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeEntity;

/**
 * DemandeEmbauche
 *
 * @ORM\Table(name="demande_simple")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeSimpleRepository")
 */
class DemandeSimple extends DemandeEntity
{
  /**
   * @var string
   *
   * @ORM\Column(name="message", type="string", nullable=true)
   */
  private $message;

  /**
   * @var string
   *
   * @ORM\Column(name="doc_service", type="string", length=255, nullable=true)
   */
  protected $docService;
  
  /**
   * Set message
   *
   * @param string $message
   *
   * @return Demande
   */
  public function setMessage($message)
  {
      $this->message = $message;

      return $this;
  }

  /**
   * Get message
   *
   * @return string
   */
  public function getMessage()
  {
      return $this->message;
  }


    /**
     * Set docService
     *
     * @param string $docService
     *
     * @return DemandeSimple
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
}
