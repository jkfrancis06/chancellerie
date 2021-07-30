<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Affectation extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = "La date de fin d'affectation se chevauche avec une affectation precedente";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
