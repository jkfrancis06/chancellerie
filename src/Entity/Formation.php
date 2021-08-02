<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 * @UniqueEntity("intitule",message="Cette formation a ete deja cree")
 */
class Formation
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
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireFormation::class, mappedBy="formation", orphanRemoval=true)
     */
    private $militaireFormations;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function __construct()
    {
        $this->militaireFormations = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|MilitaireFormation[]
     */
    public function getMilitaireFormations(): Collection
    {
        return $this->militaireFormations;
    }

    public function addMilitaireFormation(MilitaireFormation $militaireFormation): self
    {
        if (!$this->militaireFormations->contains($militaireFormation)) {
            $this->militaireFormations[] = $militaireFormation;
            $militaireFormation->setFormation($this);
        }

        return $this;
    }

    public function removeMilitaireFormation(MilitaireFormation $militaireFormation): self
    {
        if ($this->militaireFormations->removeElement($militaireFormation)) {
            // set the owning side to null (unless already changed)
            if ($militaireFormation->getFormation() === $this) {
                $militaireFormation->setFormation(null);
            }
        }

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
}
