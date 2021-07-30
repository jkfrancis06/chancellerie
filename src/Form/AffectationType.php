<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Grade;
use App\Entity\Unite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date de mutation : ',
                'html5' => false,
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
            ->add('dateFin', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label' => 'Date de fin de mutation : ',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],
            ])
            ->add('fonction', TextType::class, [
                'required' => true,
                'label' => 'Adresse : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('unite', EntityType::class, [
                'class' => Unite::class,
                'label' => 'Grade : ',
                'choice_label' => function (Unite $unite) {
                    return $unite->getIntitule() . ' / ' . $unite->getCorps()->getIntitule();

                    // or better, move this logic to Customer, and return:
                    // return $customer->getFullname();
                },
                'placeholder' => 'Choisir une unite'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
