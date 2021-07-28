<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FamilleRepository::class)
 */
class Famille
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeFiliation;

    /**
     * @ORM\ManyToMany(targetEntity=Militaire::class, inversedBy="familles")
     */
    private $militaire;

    public function __construct()
    {
        $this->militaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTypeFiliation(): ?string
    {
        return $this->typeFiliation;
    }

    public function setTypeFiliation(string $typeFiliation): self
    {
        $this->typeFiliation = $typeFiliation;

        return $this;
    }

    /**
     * @return Collection|Militaire[]
     */
    public function getMilitaire(): Collection
    {
        return $this->militaire;
    }

    public function addMilitaire(Militaire $militaire): self
    {
        if (!$this->militaire->contains($militaire)) {
            $this->militaire[] = $militaire;
        }

        return $this;
    }

    public function removeMilitaire(Militaire $militaire): self
    {
        $this->militaire->removeElement($militaire);

        return $this;
    }
}
