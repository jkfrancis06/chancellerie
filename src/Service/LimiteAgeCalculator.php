<?php

namespace App\Service;

use App\Entity\Indice;
use App\Entity\Militaire;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class LimiteAgeCalculator
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }


    public function calculate(Militaire $militaire, $range){

        $limit = ($militaire->getGrade()->getLimiteAge())*12;


        $date = new \DateTime();
        $difference = $this->nb_mois($militaire->getDateNaissance(),$date);



       return ($difference) >= ($limit-$range);


    }


    public function nb_mois($begin, $end)
    {
        $end = $end->modify( '+1 month' );

        $interval = \DateInterval::createFromDateString('1 month');

        $period = new \DatePeriod($begin, $interval, $end);
        $counter = 0;
        foreach($period as $dt) {
            $counter++;
        }

        return $counter;
    }
}