<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SearchMilitaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom : ',
            ])
            ->add('prenoms', TextType::class, [
                'label' => 'Prenoms : '
            ])
            ->add('dateNaissance', TextType::class, [
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],

            ])
            ->add('matricule', TextType::class, [
                'label' => 'Matricule : '
            ])
            ->add('sexe', ChoiceType::class, [
                'required' => true,
                'label' => 'Sexe : ',
                'choices'  => [
                    'Tous' => null,
                    'Homme' => 'h',
                    'Femme' => 'f',
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])
            ->add('taille', RangeType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 3
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
