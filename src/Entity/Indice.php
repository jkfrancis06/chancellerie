<?php

namespace App\Entity;

use App\Repository\IndiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IndiceRepository::class)
 */
class Indice
{
    const ANCIENNETE_AVANT = -1;
    const ANCIENNETE_APRES = 1;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $echelon;

    /**
     * @ORM\Column(type="float")
     */
    private $indice;

    /**
     * @ORM\Column(type="integer")
     */
    private $anciennete;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prerequation;

    /**
     * @ORM\ManyToMany(targetEntity=Grade::class, inversedBy="indices")
     */
    private $grade;

    /**
     * @ORM\Column(type="integer", options={"default": 1})
     */
    private $periodeAnciennete;

    public function __construct()
    {
        $this->grade = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEchelon(): ?int
    {
        return $this->echelon;
    }

    public function setEchelon(?int $echelon): self
    {
        $this->echelon = $echelon;

        return $this;
    }

    public function getIndice(): ?float
    {
        return $this->indice;
    }

    public function setIndice(float $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getAnciennete(): ?int
    {
        return $this->anciennete;
    }

    public function setAnciennete(int $anciennete): self
    {
        $this->anciennete = $anciennete;

        return $this;
    }

    public function getPrerequation(): ?int
    {
        return $this->prerequation;
    }

    public function setPrerequation(?int $prerequation): self
    {
        $this->prerequation = $prerequation;

        return $this;
    }

    /**
     * @return Collection|Grade[]
     */
    public function getGrade(): Collection
    {
        return $this->grade;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grade->contains($grade)) {
            $this->grade[] = $grade;
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        $this->grade->removeElement($grade);

        return $this;
    }

    public function getPeriodeAnciennete(): ?int
    {
        return $this->periodeAnciennete;
    }

    public function setPeriodeAnciennete(int $periodeAnciennete): self
    {
        $this->periodeAnciennete = $periodeAnciennete;

        return $this;
    }

}
