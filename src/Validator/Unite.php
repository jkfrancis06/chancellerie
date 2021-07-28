<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Unite extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Cette unite existe deja dans ce corps';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
