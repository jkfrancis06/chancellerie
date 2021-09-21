<?php

namespace App\Form;

use App\Entity\Exercice;
use App\Entity\MilitaireExercice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MilitaireExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exercice', EntityType::class, [
                'class' => Exercice::class,
                'label' => 'Exercice : ',
                'choice_label' => function (Exercice $exercice) {
                    return $exercice->getIntitule() . ' / ' . $exercice->getLieu();

                    // or better, move this logic to Customer, and return:
                    // return $customer->getFullname();
                },
                'placeholder' => 'Choisir un exercice'
            ])
            ->add('date', DateType::class, [
                'required' => true,
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],

                'constraints' => [
                    new NotBlank()
                ]

            ])
            ->add('commentaire', TextareaType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MilitaireExercice::class,
        ]);
    }
}
