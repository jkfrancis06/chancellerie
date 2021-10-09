<?php

namespace App\Service;

use App\Entity\MilitaireStatut;

class StringToHex
{

    function stringToColorCode($str) {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return $code;
    }


    public function getString($statut) {
        return match ($statut) {
            MilitaireStatut::STATUT_RETRAITE => "2986cc",
            MilitaireStatut::STATUT_RADIE => "f44336",
            MilitaireStatut::STATUT_PERM_LD => "99A893",
            MilitaireStatut::STATUT_SERVICE => "6aa84f",
            MilitaireStatut::STATUT_DISPONIBILITE => "DABF86",
            MilitaireStatut::STATUT_DETACHEMENT => "274e13",
            MilitaireStatut::STATUT_DESERTEUR => "e69138",
            MilitaireStatut::STATUT_ABSENCE => "ffd966",
            MilitaireStatut::STATUT_ARR_MALADIE => "351c75",
            default => "",
        };
    }

}