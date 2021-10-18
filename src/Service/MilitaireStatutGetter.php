<?php

namespace App\Service;

use App\Entity\MilitaireSpa;
use App\Entity\MilitaireStatut;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class MilitaireStatutGetter
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function loadLastSpa($militaire) {

          return $militaire->getStatut();


        //$this->entityManager->getRepository(MilitaireSpa::class)->findLastSpa($militaire);
    }

    public function getString($statut) {
        return match ($statut) {
            MilitaireStatut::STATUT_RETRAITE => "text-warning",
            MilitaireStatut::STATUT_RADIE => "text-danger",
            MilitaireStatut::STATUT_PERM_LD => "text-default",
            MilitaireStatut::STATUT_SERVICE => "text-success",
            MilitaireStatut::STATUT_DISPONIBILITE => "text-warning",
            MilitaireStatut::STATUT_DETACHEMENT => "text-default   ",
            MilitaireStatut::STATUT_DESERTEUR => "text-danger",
            MilitaireStatut::STATUT_ABSENCE => "text-warning",
            MilitaireStatut::STATUT_ARR_MALADIE => "text-warning",
            default => "",
        };
    }

}