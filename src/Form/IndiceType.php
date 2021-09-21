<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\Indice;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class IndiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('echelon', NumberType::class, [
                'label' => 'Echelon : ',
            ])
            ->add('indice', NumberType::class, [
                'required' => true,
                'label' => 'Indice : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('anciennete', NumberType::class, [
                'required' => true,
                'label' => 'Anciennete : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('prerequation', NumberType::class, [
                'label' => 'Prerequation : ',
            ])
            ->add('periodeAnciennete', ChoiceType::class, [
                'required' => true,
                'label' => 'Periode : ',
                'choices'  => [
                    'Apres' => Indice::ANCIENNETE_APRES,
                    'Avant' => Indice::ANCIENNETE_AVANT,
                ],
                'constraints' => [
                    new NotBlank()
                ],
            ])
            ->add('grade', EntityType::class, [
                'class' => Grade::class,
                'label' => 'Grade : ',
                'placeholder' => 'Choisir un grade',
                'multiple' => true,
                'choice_label' => function(Grade $grade){
                    return $grade->getDescription() . ' (' . $grade->getIntitule() . ')';
                }
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Indice::class,
        ]);
    }
}
