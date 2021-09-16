<?php

namespace App\Entity;

use App\Repository\UniteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Validator as AppAssert;

/**
 * @ORM\Entity(repositoryClass=UniteRepository::class)
 */
class Unite
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
     * @ORM\ManyToOne(targetEntity=Corps::class, inversedBy="unites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $corps;

    /**
     * @ORM\OneToMany(targetEntity=Affectation::class, mappedBy="unite", orphanRemoval=true)
     */
    private $affectations;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="formationDirected")
     */
    private $chefFormation;

    /**
     * @ORM\OneToMany(targetEntity=Spa::class, mappedBy="unite", orphanRemoval=true)
     */
    private $spas;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
        $this->spas = new ArrayCollection();
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

    public function getCorps(): ?Corps
    {
        return $this->corps;
    }

    public function setCorps(?Corps $corps): self
    {
        $this->corps = $corps;

        return $this;
    }

    /**
     * @return Collection|Affectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setUnite($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getUnite() === $this) {
                $affectation->setUnite(null);
            }
        }

        return $this;
    }

    public function getChefFormation(): ?Militaire
    {
        return $this->chefFormation;
    }

    public function setChefFormation(?Militaire $chefFormation): self
    {
        $this->chefFormation = $chefFormation;

        return $this;
    }

    /**
     * @return Collection|Spa[]
     */
    public function getSpas(): Collection
    {
        return $this->spas;
    }

    public function addSpa(Spa $spa): self
    {
        if (!$this->spas->contains($spa)) {
            $this->spas[] = $spa;
            $spa->setUnite($this);
        }

        return $this;
    }

    public function removeSpa(Spa $spa): self
    {
        if ($this->spas->removeElement($spa)) {
            // set the owning side to null (unless already changed)
            if ($spa->getUnite() === $this) {
                $spa->setUnite(null);
            }
        }

        return $this;
    }

    public function __toString():string{
        return $this->description.' ('.$this->intitule.')';
    }
}
