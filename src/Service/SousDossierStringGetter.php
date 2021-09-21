<?php

namespace App\Service;

use App\Entity\Affectation;
use App\Entity\Indice;
use App\Entity\Militaire;
use App\Entity\SousDossier;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class SousDossierStringGetter
{



    public function getString($dossier){

        switch ($dossier){

            case SousDossier::PIECE_MATRICULES :
                return "Pieces Matricules";
            case SousDossier::PIECE_ETAT_CIVIL :
                return "Pieces Etat Civil";
            case SousDossier::PIECE_ARCHIVE_MEDICALES :
                return "Pieces Archive Medicale";
            case SousDossier::PIECE_MUTATIONS :
                return "Pieces Mutations";
            case SousDossier::PIECE_PUNITIONS :
                return "Pieces Punitions";
            case SousDossier::PIECE_DIVERS :
                return "Pieces Divers";
            case SousDossier::PIECE_NOTES :
                return "Pieces Fiches de notations";
            case SousDossier::PIECE_STAGES_ECOLES :
                return "Pieces Stages-Ecoles-Formations";
            case SousDossier::PIECE_MEMOIRES :
                return "Pieces Memoires";
            case SousDossier::PIECE_DECORATIONS :
                return "Pieces decorations";
            default:
                return "Pieces indetermines";
        }
    }
}