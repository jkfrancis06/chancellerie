<?php

namespace App\Validator;

use App\Entity\MilitaireFormation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FormationValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Formation */

        if (null === $value || '' === $value) {
            return;
        }

        $today = new \DateTime();

        if ($value->getStatut() == MilitaireFormation::FORM_DONE){

            if ($value->getDateDebut()->getTimeStamp() > $today->getTimestamp()){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', '')
                    ->addViolation();
            }

        }else{

            if ($value->getDateDebut()->getTimeStamp() < $today->getTimestamp()){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', '')
                    ->addViolation();
            }

        }


    }
}
