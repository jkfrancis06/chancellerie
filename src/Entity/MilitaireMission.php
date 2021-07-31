<?php

namespace App\Entity;

use App\Repository\MilitaireMissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MilitaireMissionRepository::class)
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
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
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
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="militaireMissions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mission;

    /**
     * @ORM\OneToMany(targetEntity=Fichier::class, mappedBy="militaireMission")
     */
    private $piecesJoints;

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

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
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

    /**
     * @return Collection|Fichier[]
     */
    public function getPiecesJoints(): Collection
    {
        return $this->piecesJoints;
    }

    public function addPiecesJoint(Fichier $piecesJoint): self
    {
        if (!$this->piecesJoints->contains($piecesJoint)) {
            $this->piecesJoints[] = $piecesJoint;
            $piecesJoint->setMilitaireMission($this);
        }

        return $this;
    }

    public function removePiecesJoint(Fichier $piecesJoint): self
    {
        if ($this->piecesJoints->removeElement($piecesJoint)) {
            // set the owning side to null (unless already changed)
            if ($piecesJoint->getMilitaireMission() === $this) {
                $piecesJoint->setMilitaireMission(null);
            }
        }

        return $this;
    }
}
