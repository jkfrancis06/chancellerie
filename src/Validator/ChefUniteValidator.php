<?php

namespace App\Validator;

use App\Service\AffectationGetter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ChefUniteValidator extends ConstraintValidator
{

    private $entityManager;
    private $affectationGetter;

    public function __construct(EntityManagerInterface $entityManager, AffectationGetter $affectationGetter){
        $this->entityManager = $entityManager;
        $this->affectationGetter = $affectationGetter;

    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\ChefUnite */



        if (null === $value || '' === $value) {
            return;
        }


        $lastAffectation = $this->affectationGetter->getLastAffectation($value->getMilitaire());

        if ($lastAffectation != null && $lastAffectation->getUnite() != $value->getUnite()){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', "$value")
                ->addViolation();
        }




        // TODO: implement the validation here

    }
}
