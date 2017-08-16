<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="document", indexes={@ORM\Index(name="fk_document_personnel1_idx", columns={"personnel_id"}), @ORM\Index(name="fk_document_type_document1_idx", columns={"type_document_id"})})
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


}

