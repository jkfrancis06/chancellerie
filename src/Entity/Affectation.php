<?php

namespace App\Entity;

use App\Repository\AffectationRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as AppAssert;

/**
 * @ORM\Entity(repositoryClass=AffectationRepository::class)
 * @AppAssert\DateInterval()
 * @AppAssert\Affectation()
 */
class Affectation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="affectations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $militaire;

    /**
     * @ORM\ManyToOne(targetEntity=Unite::class, inversedBy="affectations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unite;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fonction;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;


    private $addPiece;

    /**
     * @ORM\OneToOne(targetEntity=Piece::class, cascade={"persist", "remove"})
     */
    private $piece;

    /**
     * @ORM\ManyToOne(targetEntity=Corps::class, inversedBy="affectations")
     */
    private $corps;


    public function __construct(){
        $this->isActive = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMilitaire(): ?Militaire
    {
        return $this->militaire;
    }

    public function setMilitaire(?Militaire $militaire): self
    {
        $this->militaire = $militaire;

        return $this;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }


    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPiece(): ?Piece
    {
        return $this->piece;
    }

    public function setPiece(?Piece $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getCorps(): ?Corps
    {
        return $this->corps;
    }

    public function setCorps(?Corps $corps): self
    {
        $this->corps = $corps;

        return $this;
    }


    public function getAddPiece()
    {
        return $this->addPiece;
    }


    public function setAddPiece($addPiece): void
    {
        $this->addPiece = $addPiece;
    }

}
