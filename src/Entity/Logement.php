<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogementRepository::class)
 */
class Logement
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
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity=Militaire::class, mappedBy="logement", cascade={"persist", "remove"})
     */
    private $militaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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
            $this->militaire->setLogement(null);
        }

        // set the owning side of the relation if necessary
        if ($militaire !== null && $militaire->getLogement() !== $this) {
            $militaire->setLogement($this);
        }

        $this->militaire = $militaire;

        return $this;
    }
}
