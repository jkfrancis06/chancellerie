<?php

namespace App\Service;

use App\Entity\Indice;
use App\Entity\Militaire;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class IndiceCalculator
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }


    public function calculateIndice($id){

        if ($id instanceof Militaire){
            $militaire = $id;
        }else{
            $militaire = $this->entityManager->getRepository(Militaire::class)->find($id);
        }


        if ($militaire == null){
            return null;
        }

        $now = new \DateTime();

        $annees_service = $now->diff($militaire->getDateIncorp())->y;

        $indices = $militaire->getGrade()->getIndices();


        if ($indices == null){
            return null;
        }

        $temp_indices = $indices;


        $iterator = $temp_indices->getIterator();
        $iterator->uasort(function ($a, $b) {
            return ($a->getIndice() < $b->getIndice()) ? -1 : 1;
        });
        $temp_indices = new ArrayCollection(iterator_to_array($iterator));

        $i = 0;
        foreach ($temp_indices as $indice){
            if ($i == 0) {  // si c'est l'indice le plus faible
                if ($indice->getPeriodeAnciennete() == Indice::ANCIENNETE_AVANT) {  // si c'est avant la periode 
                    if ($annees_service < $indice->getAnciennete()) {
                        return $indice;
                    }
                }
            }else {
                if ($i == sizeof($temp_indices) - 1) {  // dernier

                    if ($temp_indices[$i]->getAnciennete() <= $annees_service) {
                        return $indice;
                    }
                } else {
                    if ($temp_indices[$i - 1]->getAnciennete() <= $annees_service && $annees_service < $temp_indices[$i + 1]->getAnciennete()) {
                        return $indice;
                    }
                }
            }

            $i++;
        }




    }
}