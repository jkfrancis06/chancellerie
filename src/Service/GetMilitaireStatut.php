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
        return $this->entityManager->getRepository(MilitaireStatut::class)->getMilitaireStatut($militaire);
    }

}