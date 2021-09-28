<?php

namespace App\Form;

use App\Entity\Mission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MissionEmbedType extends AbstractType
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
            ->add('type', ChoiceType::class, [
                'required' => true,
                'label' => 'Type : ',
                'choices'  => [
                    'Exterieure' => 'Exterieure',
                    'Locale' => 'Locale',
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])
            ->add('lieu', TextType::class, [
                'label' => 'lieu',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'commentaire',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
