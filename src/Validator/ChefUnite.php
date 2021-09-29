<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ChefUnite extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Le chef de formation doit appartenir a cette unite.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
