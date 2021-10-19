<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=PieceRepository::class)
 */
class Piece
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datePiece;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroOrdre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=SousDossier::class, inversedBy="pieces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sousDossier;

    /**
     * @var UploadedFile
     */
    protected $file;



    public function __construct()
    {
        $this->punitions = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePiece(): ?\DateTimeInterface
    {
        return $this->datePiece;
    }

    public function setDatePiece(?\DateTimeInterface $datePiece): self
    {
        $this->datePiece = $datePiece;

        return $this;
    }

    public function getNumeroOrdre(): ?int
    {
        return $this->numeroOrdre;
    }

    public function setNumeroOrdre(?int $numeroOrdre): self
    {
        $this->numeroOrdre = $numeroOrdre;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSousDossier(): ?SousDossier
    {
        return $this->sousDossier;
    }

    public function setSousDossier(?SousDossier $sousDossier): self
    {
        $this->sousDossier = $sousDossier;

        return $this;
    }

    /**
     * @param UploadedFile $file - Uploaded File
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return Collection|Punition[]
     */
    public function getPunitions(): Collection
    {
        return $this->punitions;
    }




}
