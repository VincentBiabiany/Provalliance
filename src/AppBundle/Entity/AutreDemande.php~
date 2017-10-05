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
     * @ORM\Column(name="personnel_id", type="integer", nullable=true)
     */
    private $idPersonnel;

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
    private $pieceJointes;


    /**
     * Set collaborateur
     *
     * @param string $collaborateur
     *
     * @return AutreDemande
     */
    public function setCollaborateur($collaborateur)
    {
        $this->collaborateur = $collaborateur;

        return $this;
    }

    /**
     * Get collaborateur
     *
     * @return string
     */
    public function getCollaborateur()
    {
        return $this->collaborateur;
    }

    /**
     * Set idPersonnel
     *
     * @param integer $idPersonnel
     *
     * @return AutreDemande
     */
    public function setIdPersonnel($idPersonnel)
    {
        $this->idPersonnel = $idPersonnel;

        return $this;
    }

    /**
     * Get idPersonnel
     *
     * @return integer
     */
    public function getIdPersonnel()
    {
        return $this->idPersonnel;
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
}
