<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiplomeRepository::class)
 */
class Diplome
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireDiplome::class, mappedBy="diplome", orphanRemoval=true)
     */
    private $militaireDiplomes;

    public function __construct()
    {
        $this->militaireDiplomes = new ArrayCollection();
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
     * @return Collection|MilitaireDiplome[]
     */
    public function getMilitaireDiplomes(): Collection
    {
        return $this->militaireDiplomes;
    }

    public function addMilitaireDiplome(MilitaireDiplome $militaireDiplome): self
    {
        if (!$this->militaireDiplomes->contains($militaireDiplome)) {
            $this->militaireDiplomes[] = $militaireDiplome;
            $militaireDiplome->setDiplome($this);
        }

        return $this;
    }

    public function removeMilitaireDiplome(MilitaireDiplome $militaireDiplome): self
    {
        if ($this->militaireDiplomes->removeElement($militaireDiplome)) {
            // set the owning side to null (unless already changed)
            if ($militaireDiplome->getDiplome() === $this) {
                $militaireDiplome->setDiplome(null);
            }
        }

        return $this;
    }
}
