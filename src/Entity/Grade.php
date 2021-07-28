<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=GradeRepository::class)
 * @UniqueEntity("intitule",message="Ce grade a ete deja cree")
 */
class Grade
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
     * @ORM\ManyToOne(targetEntity=GradeCategorie::class, inversedBy="grades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gradeCategorie;

    /**
     * @ORM\OneToMany(targetEntity=Militaire::class, mappedBy="grade")
     */
    private $militaires;

    public function __construct()
    {
        $this->militaires = new ArrayCollection();
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

    public function getGradeCategorie(): ?GradeCategorie
    {
        return $this->gradeCategorie;
    }

    public function setGradeCategorie(?GradeCategorie $gradeCategorie): self
    {
        $this->gradeCategorie = $gradeCategorie;

        return $this;
    }

    /**
     * @return Collection|Militaire[]
     */
    public function getMilitaires(): Collection
    {
        return $this->militaires;
    }

    public function addMilitaire(Militaire $militaire): self
    {
        if (!$this->militaires->contains($militaire)) {
            $this->militaires[] = $militaire;
            $militaire->setGrade($this);
        }

        return $this;
    }

    public function removeMilitaire(Militaire $militaire): self
    {
        if ($this->militaires->removeElement($militaire)) {
            // set the owning side to null (unless already changed)
            if ($militaire->getGrade() === $this) {
                $militaire->setGrade(null);
            }
        }

        return $this;
    }
}
