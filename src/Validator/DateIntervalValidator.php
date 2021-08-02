<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateIntervalValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\DateInterval */

        if ($value->getDateFin() != null){
            if ($value->getDateDebut()->getTimestamp() > $value->getDateFin()->getTimestamp()){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value->getDateDebut()->getTimestamp())
                    ->addViolation();
            }
        }



        if (null === $value || '' === $value) {
            return;
        }

    }
}
