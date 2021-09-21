<?php

namespace App\Entity;

use App\Repository\MedailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MedailleRepository::class)
 * @UniqueEntity("designation",message="Cette medaille/distinction a ete deja cree")
 */
class Medaille
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
    private $designation;


    /**
     * @ORM\OneToMany(targetEntity=MilitaireMedaille::class, mappedBy="medaille")
     */
    private $militaireMedailles;

    public function __construct()
    {
        $this->militaireMedailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|MilitaireMedaille[]
     */
    public function getMilitaireMedailles(): Collection
    {
        return $this->militaireMedailles;
    }

    public function addMilitaireMedaille(MilitaireMedaille $militaireMedaille): self
    {
        if (!$this->militaireMedailles->contains($militaireMedaille)) {
            $this->militaireMedailles[] = $militaireMedaille;
            $militaireMedaille->setMedaille($this);
        }

        return $this;
    }

    public function removeMilitaireMedaille(MilitaireMedaille $militaireMedaille): self
    {
        if ($this->militaireMedailles->removeElement($militaireMedaille)) {
            // set the owning side to null (unless already changed)
            if ($militaireMedaille->getMedaille() === $this) {
                $militaireMedaille->setMedaille(null);
            }
        }

        return $this;
    }
}
