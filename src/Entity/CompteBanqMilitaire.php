<?php

namespace App\Entity;

use App\Repository\CompteBanqMilitaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CompteBanqMilitaireRepository::class)
 * @UniqueEntity("numeroCompte", message="Ce compte est deja existant")
 */
class CompteBanqMilitaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $institution;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToOne(targetEntity=Militaire::class, mappedBy="compteBanquaire", cascade={"persist", "remove"})
     */
    private $militaire;


    public function __construct(){
        $this->isActive = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function setInstitution(?string $institution): self
    {
        $this->institution = $institution;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getMilitaire(): ?Militaire
    {
        return $this->militaire;
    }

    public function setMilitaire(?Militaire $militaire): self
    {
        // unset the owning side of the relation if necessary
        if ($militaire === null && $this->militaire !== null) {
            $this->militaire->setCompteBanquaire(null);
        }

        // set the owning side of the relation if necessary
        if ($militaire !== null && $militaire->getCompteBanquaire() !== $this) {
            $militaire->setCompteBanquaire($this);
        }

        $this->militaire = $militaire;

        return $this;
    }


}
