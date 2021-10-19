<?php

namespace App\Entity;

use App\Repository\PunitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PunitionRepository::class)
 */
class Punition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="punitions")
     */
    private $militaireFautif;

    /**
     * @ORM\ManyToMany(targetEntity=Militaire::class, inversedBy="demandesPunitions")
     */
    private $militairesDemandeurs;

    /**
     * @ORM\Column(type="date")
     */
    private $datePunition;

    /**
     * @ORM\Column(type="text")
     */
    private $motif;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\Column(type="integer")
     */
    private $dureeDemade;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;


    public function __construct(

    )
    {
        $this->militairesDemandeurs = new ArrayCollection();
        $this->statut = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMilitaireFautif(): ?Militaire
    {
        return $this->militaireFautif;
    }

    public function setMilitaireFautif(?Militaire $militaireFautif): self
    {
        $this->militaireFautif = $militaireFautif;

        return $this;
    }

    /**
     * @return Collection|Militaire[]
     */
    public function getMilitairesDemandeurs(): Collection
    {
        return $this->militairesDemandeurs;
    }

    public function addMilitairesDemandeur(Militaire $militairesDemandeur): self
    {
        if (!$this->militairesDemandeurs->contains($militairesDemandeur)) {
            $this->militairesDemandeurs[] = $militairesDemandeur;
        }

        return $this;
    }

    public function removeMilitairesDemandeur(Militaire $militairesDemandeur): self
    {
        $this->militairesDemandeurs->removeElement($militairesDemandeur);

        return $this;
    }

    public function getDatePunition(): ?\DateTimeInterface
    {
        return $this->datePunition;
    }

    public function setDatePunition(\DateTimeInterface $datePunition): self
    {
        $this->datePunition = $datePunition;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDureeDemade(): ?int
    {
        return $this->dureeDemade;
    }

    public function setDureeDemade(int $dureeDemade): self
    {
        $this->dureeDemade = $dureeDemade;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

}
