<?php

namespace App\Entity;

use App\Repository\CorpsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CorpsRepository::class)
 * @UniqueEntity("intitule",message="Ce corps a ete deja cree")
 */
class Corps
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
     * @ORM\OneToMany(targetEntity=Fichier::class, mappedBy="corps",cascade={"persist"})
     */
    private $fichiers;

    /**
     * @ORM\OneToMany(targetEntity=Unite::class, mappedBy="corps")
     */
    private $unites;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
        $this->unites = new ArrayCollection();
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

    /**
     * @return Collection|Fichier[]
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setCorps($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getCorps() === $this) {
                $fichier->setCorps(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Unite[]
     */
    public function getUnites(): Collection
    {
        return $this->unites;
    }

    public function addUnite(Unite $unite): self
    {
        if (!$this->unites->contains($unite)) {
            $this->unites[] = $unite;
            $unite->setCorps($this);
        }

        return $this;
    }

    public function removeUnite(Unite $unite): self
    {
        if ($this->unites->removeElement($unite)) {
            // set the owning side to null (unless already changed)
            if ($unite->getCorps() === $this) {
                $unite->setCorps(null);
            }
        }

        return $this;
    }


    function stringToColorCode() {
        $code = dechex(crc32($this->intitule));
        return substr($code, 0, 6);
    }


}
