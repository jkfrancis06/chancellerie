<?php

namespace App\Service;

use App\Entity\Indice;
use App\Entity\Militaire;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class Encoder
{



    public function encode($matricule){
        return md5($matricule);
    }
}