<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Famille extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Le lien de filiation est invalide';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
