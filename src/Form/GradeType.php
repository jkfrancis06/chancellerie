<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\GradeCategorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', TextType::class, [
                'label' => 'Intitule',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('description',
                TextType::class, [
                    'label' => 'Description',
                    'constraints' => [
                        new NotBlank()
                    ]
                ])
            ->add('limiteAge', IntegerType::class, [
                'label' => 'limiteAge',
                'help' => "Entrer la limite d'age, 0 pour aucun",
            ])
            ->add('gradeCategorie', EntityType::class, [
                'class' => GradeCategorie::class,

                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une categorie'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
        ]);
    }
}
