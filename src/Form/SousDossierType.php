<?php

namespace App\Form;

use App\Entity\SousDossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousDossierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pieces', CollectionType::class, [
                'required' => false,
                'entry_type' => PieceType::class,
                'block_name' => 'pieces_lists',
                'label'=> '  ',
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype_name' => '__pieces_prot__',
                'attr' => array (
                    'class' => "piece-collection table table-bordered",
                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousDossier::class,
        ]);
    }


    public function getBlockPrefix()
    {
        return 'SousDossierType';
    }
}
