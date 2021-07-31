<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 */
class Exercice
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
    private $lieu;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;


    /**
     * @ORM\OneToMany(targetEntity=MilitaireExercice::class, mappedBy="exercice", orphanRemoval=true)
     */
    private $militaireExercices;

    public function __construct()
    {
        $this->militaireExercices = new ArrayCollection();
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


    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }


    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }


    /**
     * @return Collection|MilitaireExercice[]
     */
    public function getMilitaireExercices(): Collection
    {
        return $this->militaireExercices;
    }

    public function addMilitaireExercice(MilitaireExercice $militaireExercice): self
    {
        if (!$this->militaireExercices->contains($militaireExercice)) {
            $this->militaireExercices[] = $militaireExercice;
            $militaireExercice->setExercice($this);
        }

        return $this;
    }

    public function removeMilitaireExercice(MilitaireExercice $militaireExercice): self
    {
        if ($this->militaireExercices->removeElement($militaireExercice)) {
            // set the owning side to null (unless already changed)
            if ($militaireExercice->getExercice() === $this) {
                $militaireExercice->setExercice(null);
            }
        }

        return $this;
    }
}
