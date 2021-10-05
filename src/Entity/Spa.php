<?php

namespace App\Entity;

use App\Repository\SpaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpaRepository::class)
 */
class Spa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireSpa::class, mappedBy="spa", orphanRemoval=true)
     */
    private $militaireSpas;

    /**
     * @ORM\ManyToOne(targetEntity=Unite::class, inversedBy="spas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unite;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="spas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSpa;



    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->militaireSpas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
     * @return Collection|MilitaireSpa[]
     */
    public function getMilitaireSpas(): Collection
    {
        return $this->militaireSpas;
    }

    public function addMilitaireSpa(MilitaireSpa $militaireSpa): self
    {
        if (!$this->militaireSpas->contains($militaireSpa)) {
            $this->militaireSpas[] = $militaireSpa;
            $militaireSpa->setSpa($this);
        }

        return $this;
    }

    public function removeMilitaireSpa(MilitaireSpa $militaireSpa): self
    {
        if ($this->militaireSpas->removeElement($militaireSpa)) {
            // set the owning side to null (unless already changed)
            if ($militaireSpa->getSpa() === $this) {
                $militaireSpa->setSpa(null);
            }
        }

        return $this;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getCreatedBy(): ?Militaire
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Militaire $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getDateSpa(): ?\DateTimeInterface
    {
        return $this->dateSpa;
    }

    public function setDateSpa(\DateTimeInterface $dateSpa): self
    {
        $this->dateSpa = $dateSpa;

        return $this;
    }
}
