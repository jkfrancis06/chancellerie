<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniteValidator extends ConstraintValidator
{

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }

    public function validate($unite, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Unite */

        $db_unite = $this->entityManager->getRepository(\App\Entity\Unite::class)->findBy([
           'corps' => $unite->getCorps(),
           'intitule' => $unite->getIntitule()
        ]);

        if ($db_unite != null){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $unite->getIntitule())
                ->addViolation();
        }


        if (null === $unite || '' === $unite) {
            return;
        }

        // TODO: implement the validation here

    }
}
