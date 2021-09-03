<?php

namespace App\Entity;

use App\Repository\SousDossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousDossierRepository::class)
 */
class SousDossier
{

    CONST PIECE_INDETERMINES = 0;
    CONST PIECE_MATRICULES = 1;
    CONST PIECE_ETAT_CIVIL = 2;
    CONST PIECE_MUTATIONS = 3;
    CONST PIECE_ARCHIVE_MEDICALES = 4;
    CONST PIECE_DIVERS = 5;
    CONST PIECE_NOTES = 6;
    CONST PIECE_STAGES_ECOLES = 7;
    CONST PIECE_MEMOIRES = 8;
    CONST PIECE_DECORATIONS = 9;
    CONST PIECE_PUNITIONS = 10;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Piece::class, mappedBy="sousDossier", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $pieces;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="sousDossiers")
     */
    private $militaire;

    public function __construct()
    {
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Piece[]
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): self
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces[] = $piece;
            $piece->setSousDossier($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): self
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getSousDossier() === $this) {
                $piece->setSousDossier(null);
            }
        }

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
}
