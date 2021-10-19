<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\MilitaireFormation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MilitaireFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'placeholder' => 'Selectionner une date'
                ],

                'constraints' => [
                    new NotBlank()
                ]

            ])
            ->add('dateFin', DateType::class, [
                'required' => false,
                'html5' => true,
                'widget' => 'single_text',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'placeholder' => 'Selectionner une date'
                ],

            ])
            ->add('statut', ChoiceType::class, [
                'required' => true,
                'choices'  => [
                    'A programmer' => MilitaireFormation::FORM_PLAN,
                    'Fait' => MilitaireFormation::FORM_DONE,
                ],
                'attr' => [
                    'placeholder' => 'Selectionner',

                ],
            ])
            ->add('lieu', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('formation', EntityType::class, [
                'class' => Formation::class,

                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une formation'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MilitaireFormation::class,
        ]);
    }
}
