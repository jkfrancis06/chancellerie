<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 * @UniqueEntity("intitule",message="Cette mission existe deja")
 */
class Mission
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireMission::class, mappedBy="mission", orphanRemoval=true)
     */
    private $militaireMissions;

    /**
     * @ORM\ManyToOne(targetEntity=Fichier::class,cascade={"persist"})
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    public function __construct()
    {
        $this->militaireMissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|MilitaireMission[]
     */
    public function getMilitaireMissions(): Collection
    {
        return $this->militaireMissions;
    }

    public function addMilitaireMission(MilitaireMission $militaireMission): self
    {
        if (!$this->militaireMissions->contains($militaireMission)) {
            $this->militaireMissions[] = $militaireMission;
            $militaireMission->setMission($this);
        }

        return $this;
    }

    public function removeMilitaireMission(MilitaireMission $militaireMission): self
    {
        if ($this->militaireMissions->removeElement($militaireMission)) {
            // set the owning side to null (unless already changed)
            if ($militaireMission->getMission() === $this) {
                $militaireMission->setMission(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?Fichier
    {
        return $this->logo;
    }

    public function setLogo(?Fichier $logo): self
    {
        $this->logo = $logo;

        return $this;
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
}
