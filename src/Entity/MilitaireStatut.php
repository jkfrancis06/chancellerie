<?php

namespace App\Entity;

use App\Repository\MilitaireStatutRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as AppAssert;

/**
 * @ORM\Entity(repositoryClass=MilitaireStatutRepository::class)
 * @AppAssert\DateInterval()
 */
class MilitaireStatut
{



    const STATUT_RETRAITE = 0;
    const STATUT_RADIE = 1;
    const STATUT_PERM_LD = 2;
    const STATUT_SERVICE = 3;
    const STATUT_DISPONIBILITE = 4;
    const STATUT_DETACHEMENT = 5;
    const STATUT_DESERTEUR = 6;
    const STATUT_ABSENCE = 7;
    const STATUT_ARR_MALADIE = 8;



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Militaire::class, inversedBy="militaireStatuts")
     */
    private $militaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(?int $statut): self
    {
        $this->statut = $statut;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface                                             
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }
}
