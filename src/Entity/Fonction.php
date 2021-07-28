<?php

namespace App\Entity;

use App\Repository\FonctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FonctionRepository::class)
 */
class Fonction
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
    private $intitule;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireFonction::class, mappedBy="fonction")
     */
    private $militaireFonctions;

    public function __construct()
    {
        $this->militaireFonctions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection|MilitaireFonction[]
     */
    public function getMilitaireFonctions(): Collection
    {
        return $this->militaireFonctions;
    }

    public function addMilitaireFonction(MilitaireFonction $militaireFonction): self
    {
        if (!$this->militaireFonctions->contains($militaireFonction)) {
            $this->militaireFonctions[] = $militaireFonction;
            $militaireFonction->setFonction($this);
        }

        return $this;
    }

    public function removeMilitaireFonction(MilitaireFonction $militaireFonction): self
    {
        if ($this->militaireFonctions->removeElement($militaireFonction)) {
            // set the owning side to null (unless already changed)
            if ($militaireFonction->getFonction() === $this) {
                $militaireFonction->setFonction(null);
            }
        }

        return $this;
    }
}
