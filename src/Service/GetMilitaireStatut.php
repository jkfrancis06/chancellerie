<?php

namespace App\Service;

use App\Entity\Affectation;
use App\Entity\Indice;
use App\Entity\Militaire;
use App\Entity\MilitaireStatut;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class GetMilitaireStatut
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }


    public function getStatut($militaire){
        return $militaire->getStatut();
    }

    public function getString($statut) {
        return match ($statut) {
            MilitaireStatut::STATUT_RETRAITE => "Retraite",
            MilitaireStatut::STATUT_RADIE => "Radie",
            MilitaireStatut::STATUT_PERM_LD => "Permission Longue-Duree",
            MilitaireStatut::STATUT_SERVICE => "En service",
            MilitaireStatut::STATUT_DISPONIBILITE => "Disponibilite",
            MilitaireStatut::STATUT_DETACHEMENT => "Detachement",
            MilitaireStatut::STATUT_DESERTEUR => "Deserteur",
            MilitaireStatut::STATUT_ABSENCE => "Absence",
            MilitaireStatut::STATUT_ARR_MALADIE => "Arrêt maladie",
            default => "",
        };
    }

}