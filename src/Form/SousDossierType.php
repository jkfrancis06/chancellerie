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
            ->add('type', ChoiceType::class, [
                'required' => true,
                'label' => 'Type de piece : ',
                'choices'  => [
                    'Indetermine' => SousDossier::PIECE_INDETERMINES,
                    'Pieces matricules' => SousDossier::PIECE_MATRICULES,
                    'Pieces etat civil' => SousDossier::PIECE_ETAT_CIVIL,
                    'Mutations ' => SousDossier::PIECE_MUTATIONS,
                    'Pieces Archives medicales' => SousDossier::PIECE_ARCHIVE_MEDICALES,
                    'Pieces diverses' => SousDossier::PIECE_DIVERS,
                    'Feuilles de notes' => SousDossier::PIECE_NOTES,
                    'Notes divers, Ecoles, Stages' => SousDossier::PIECE_STAGES_ECOLES,
                    'Memoires de proposition' => SousDossier::PIECE_MEMOIRES,
                    'Citations - Decorations - Felicitations' => SousDossier::PIECE_DECORATIONS,
                    'Punitions et Condamnations' => SousDossier::PIECE_PUNITIONS,
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])
            ->add('pieces', CollectionType::class, [
                'required' => false,
                'entry_type' => PieceType::class,
                'block_name' => 'pieces_lists',
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype_name' => '__pieces_prot__',
                'attr' => array (
                    'class' => "piece-collection",
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
