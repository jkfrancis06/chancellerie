<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as AppAssert;

/**
 * @ORM\Entity(repositoryClass=FamilleRepository::class)
 * @AppAssert\Famille()
 */
class Famille
{

    const PERE = 0;
    const MERE = 1;
    const CONJ = 2;
    const ENFANT = 4;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeFiliation;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="familles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $militaire;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTypeFiliation(): ?string
    {
        return $this->typeFiliation;
    }

    public function setTypeFiliation(string $typeFiliation): self
    {
        $this->typeFiliation = $typeFiliation;

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

    public function getMilitaire(): ?Militaire
    {
        return $this->militaire;
    }

    public function setMilitaire(?Militaire $militaire): self
    {
        $this->militaire = $militaire;

        return $this;
    }
}
