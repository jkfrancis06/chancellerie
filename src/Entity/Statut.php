<?php

namespace App\Entity;

use App\Repository\StatutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatutRepository::class)
 */
class Statut
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
     * @ORM\OneToMany(targetEntity=MilitaireStatut::class, mappedBy="statut", orphanRemoval=true)
     */
    private $militaireStatuts;

    public function __construct()
    {
        $this->militaireStatuts = new ArrayCollection();
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
     * @return Collection|MilitaireStatut[]
     */
    public function getMilitaireStatuts(): Collection
    {
        return $this->militaireStatuts;
    }

    public function addMilitaireStatut(MilitaireStatut $militaireStatut): self
    {
        if (!$this->militaireStatuts->contains($militaireStatut)) {
            $this->militaireStatuts[] = $militaireStatut;
            $militaireStatut->setStatut($this);
        }

        return $this;
    }

    public function removeMilitaireStatut(MilitaireStatut $militaireStatut): self
    {
        if ($this->militaireStatuts->removeElement($militaireStatut)) {
            // set the owning side to null (unless already changed)
            if ($militaireStatut->getStatut() === $this) {
                $militaireStatut->setStatut(null);
            }
        }

        return $this;
    }
}
