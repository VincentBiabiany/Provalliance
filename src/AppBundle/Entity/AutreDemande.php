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
    protected $service;
    protected $nomDoc = 'absence';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * ___autre_demande.collab
     *
     * @var int
     *
     * @ORM\Column(name="matricule", type="string", nullable=true)
     */
    private $matricule;

    /**
     * ___autre_demande.objet
     *
     * @var string
     *
     * @ORM\Column(name="objet", type="string", nullable=false)
     */
    private $objet;

    /**
     * ___autre_demande.commentaire
     *
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", nullable=false)
     */
    private $commentaire;


    /**
     * ___autre_demande.pieceJointe
     *
     * @var string
     *
     * @ORM\Column(name="piece_jointe", type="string", nullable=true)
     */
     private $pieceJointe;

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
     * Get nomDoc
     *
     * @return integer
     */
    public function getNomDoc()
    {
        return $this->nomDoc;
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
     * Get service
     *
     * @return integer
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set service
     *
     * @return integer
     */
    public function setService($service)
    {
        $this->service = $service;
        
        return $this;
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
     * Set pieceJointe
     *
     * @param string $pieceJointe
     *
     * @return AutreDemande
     */
    public function setPieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return string
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }
}
