<?php

namespace App\Validator;

use App\Entity\Militaire;
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

        /*
         * La date d'affectation ne doit pas etre inferieur a la date d'incorporation
         */
        $affectations = $this->entityManager->getRepository(\App\Entity\Affectation::class)->findBy([
            'militaire' => $value->getMilitaire(),
        ]);

        if ($affectations == null && $value->getDateDebut() != null){
            if ($value->getDateDebut()->getTimestamp() < $value->getMilitaire()->getDateIncorp()->getTimestamp()){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', '$value')
                    ->addViolation();
            }
        }



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
