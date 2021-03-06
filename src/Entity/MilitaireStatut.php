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

    const UPDATED_BY_CHAN = 1;
    const UPDATED_BY_CHEF_CORPS = 2;


    const STATUT_ACTIF = [
            self::STATUT_RETRAITE,
            self::STATUT_PERM_LD,
            self::STATUT_SERVICE,
            self::STATUT_DISPONIBILITE,
            self::STATUT_DETACHEMENT,
            self::STATUT_ABSENCE,
            self::STATUT_ARR_MALADIE,
        ];

    const STATUT_INACTIF = [
        self::STATUT_RADIE,
        self::STATUT_DESERTEUR
    ];


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $definedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    public function __construct()
    {
        $this->updateAt = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getDefinedBy(): ?int
    {
        return $this->definedBy;
    }

    public function setDefinedBy(?int $definedBy): self
    {
        $this->definedBy = $definedBy;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
