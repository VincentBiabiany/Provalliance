<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeForm;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\AutreDemande
 *
 * @ORM\Table(name="autre_demande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AutreDemandeRepository")
 */
class AutreDemande extends DemandeForm
{
    private $pieceJointes;
    protected $nameDemande ='AutreDemande';
    protected $typeForm ='Autre demande';
    protected $subject ='connu';
    private $service;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer", nullable=true)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", nullable=false)
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", nullable=false)
     */
    private $commentaire;


    /**
     * @var array
     *
     * @ORM\Column(name="piece_jointes", type="array", nullable=true)
     */

    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return AutreDemande
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return integer
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set objet
     *
     * @param string $objet
     *
     * @return AutreDemande
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return AutreDemande
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return AutreDemande
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

    /**
     * Set pieceJointes
     *
     * @param array $pieceJointes
     *
     * @return AutreDemande
     */
    public function setPieceJointes($pieceJointes)
    {
        $this->pieceJointes = $pieceJointes;

        return $this;
    }

    /**
     * Get pieceJointes
     *
     * @return array
     */
    public function getPieceJointes()
    {
        return $this->pieceJointes;
    }

    /**
     * Get nameDemande
     *
     * @return integer
     */
    public function getNameDemande()
    {
        return $this->nameDemande;
    }
    /**
     * Get typeForm
     *
     * @return integer
     */
    public function getTypeForm()
    {
        return $this->typeForm;
    }

    /**
     * Get subject
     *
     * @return integer
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
