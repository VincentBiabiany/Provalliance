<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="referentiel.document", indexes={@ORM\Index(name="fk_document_personnel1_idx", columns={"personnel_id"}), @ORM\Index(name="fk_document_type_document1_idx", columns={"type_document_id"})})
 * @ORM\Entity
 */
class Document
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upload", type="datetime", nullable=true)
     */
    private $dateUpload;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ApiBundle\Entity\Personnel
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personnel_id", referencedColumnName="id")
     * })
     */
    private $personnel;

    /**
     * @var \ApiBundle\Entity\TypeDocument
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\TypeDocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_document_id", referencedColumnName="id")
     * })
     */
    private $typeDocument;



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Document
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Document
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateUpload
     *
     * @param \DateTime $dateUpload
     *
     * @return Document
     */
    public function setDateUpload($dateUpload)
    {
        $this->dateUpload = $dateUpload;

        return $this;
    }

    /**
     * Get dateUpload
     *
     * @return \DateTime
     */
    public function getDateUpload()
    {
        return $this->dateUpload;
    }

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
     * Set personnel
     *
     * @param \ApiBundle\Entity\Personnel $personnel
     *
     * @return Document
     */
    public function setPersonnel(\ApiBundle\Entity\Personnel $personnel = null)
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
     * Set typeDocument
     *
     * @param \ApiBundle\Entity\TypeDocument $typeDocument
     *
     * @return Document
     */
    public function setTypeDocument(\ApiBundle\Entity\TypeDocument $typeDocument = null)
    {
        $this->typeDocument = $typeDocument;

        return $this;
    }

    /**
     * Get typeDocument
     *
     * @return \ApiBundle\Entity\TypeDocument
     */
    public function getTypeDocument()
    {
        return $this->typeDocument;
    }
}
