<?php

namespace App\Entity;

use App\Repository\MilitaireMissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MilitaireMissionRepository::class)
 * @AppAssert\DateInterval()
 */
class MilitaireMission
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
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="militaireMissions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $militaire;

    /**
     * @Assert\Type(type="App\Entity\Mission")
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="militaireMissions",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mission;


    private $addPiece;

    /**
     * @ORM\OneToOne(targetEntity=Piece::class, cascade={"persist", "remove"})
     */
    private $piece;


    public function __construct()
    {
        $this->piecesJoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
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

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): self
    {
        $this->mission = $mission;

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

    public function getPiece(): ?Piece
    {
        return $this->piece;
    }

    public function setPiece(?Piece $piece): self
    {
        $this->piece = $piece;

        return $this;
    }
}
