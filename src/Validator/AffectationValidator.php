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

        $affectations = $this->entityManager->getRepository(\App\Entity\Affectation::class)->findBy([
           'militaire' => $value->getMilitaire()
        ]);

        // TODO: Verifier les contraintes

        foreach ($affectations as $affectation){
            if ($affectation->getDateFin != null){
                if ($affectation->getDate->getTimestamp() < $value ){

                }
            }
        }

        if (null === $value || '' === $value) {
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
