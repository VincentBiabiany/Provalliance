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

}
