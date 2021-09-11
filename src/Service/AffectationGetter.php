<?php

namespace App\Service;

use App\Entity\Affectation;
use App\Entity\Indice;
use App\Entity\Militaire;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class AffectationGetter
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }


    public function getLastAffectation($militaire){
        return $this->entityManager->getRepository(Affectation::class)->findActiveAff($militaire);
    }
}