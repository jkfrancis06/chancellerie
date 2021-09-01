<?php

namespace App\Entity;

use App\Repository\MilitaireSpaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MilitaireSpaRepository::class)
 */
class MilitaireSpa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="militaireSpas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $militaire;

    /**
     * @ORM\ManyToOne(targetEntity=Spa::class, inversedBy="militaireSpas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spa;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

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

    public function getSpa(): ?Spa
    {
        return $this->spa;
    }

    public function setSpa(?Spa $spa): self
    {
        $this->spa = $spa;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
