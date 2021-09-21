<?php

namespace App\Validator;

use App\Entity\Militaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FamilleValidator extends ConstraintValidator
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /*
     * Un militaire ne peut pas avoir deux peres / meres
     * Un militaire(femme) ne peut pas avoir deux conjoints
     */

    public function validate($famille, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Famille */


        $db_militaire = $this->entityManager->getRepository(Militaire::class)->find($famille->getMilitaire()->getId());

        if ($db_militaire != null){

            $familles = $db_militaire->getFamilles();

            $hasFather = false;
            $hasMother = false;

            foreach ($familles as $item){

                if ($item->getTypeFiliation() == 0){
                    $hasFather = true;
                }
                if ($item->getTypeFiliation() == 1){
                    $hasMother = true;
                }
                if ($db_militaire->getSexe() == 'f' && $item->getTypeFiliation() == 2 && $famille->getTypeFiliation() == 2){
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $famille->getNom())
                        ->addViolation();
                    break;
                }
            }
            if (($hasMother && $famille->getTypeFiliation() == 1) || ($hasFather && $famille->getTypeFiliation() == 0) ){

                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $famille->getNom())
                    ->addViolation();
            }
        }

    }
}
