<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AffectationValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Affectation */

        $lastAffectation = $this->entityManager->getRepository(\App\Entity\Affectation::class)->findOneBy([
           'militaire' => $value->getMilitaire(),
            'isActive' => true
        ]);

        $is_valid = true;

        // TODO: Verifier les contraintes

        if ($lastAffectation != null && $value->getDateDebut() != null){


            if ($lastAffectation->getDateDebut()->getTimestamp() > $value->getDateDebut()->getTimestamp()){

                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', '$value')
                    ->addViolation();

            }




        }

    }
}
