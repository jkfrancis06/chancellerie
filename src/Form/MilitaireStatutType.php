<?php

namespace App\Form;

use App\Entity\MilitaireStatut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MilitaireStatutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', TextareaType::class, [
                'required' => true,

            ])
            ->add('dateDebut', DateType::class, [
                'required' => false,
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],

            ])
            ->add('dateFin', DateType::class, [
                'required' => false,
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],


            ])
            ->add('statut', ChoiceType::class, [
                'required' => true,
                'choices'  => [
                    'Selectionner' => null,
                    'Retraite' => 0,
                    'Radie' => 1,
                    'Permission longue-duree' => 2,
                    'En service' => 3,
                    'Disponibilite' => 4,
                    'Detachement' => 5,
                    'Deserteur' => 6,
                    'Absence' => 7,
                    'Arret maladie' => 8,
                ],
                'attr' => [
                    'placeholder' => 'Selectionner',
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MilitaireStatut::class,
        ]);
    }
}
