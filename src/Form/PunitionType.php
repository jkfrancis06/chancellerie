<?php

namespace App\Form;

use App\Entity\Militaire;
use App\Entity\Piece;
use App\Entity\Punition;
use App\Entity\SousDossier;
use App\Service\SousDossierStringGetter;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class PunitionType extends AbstractType
{

    private $stringGetter;

    public function __construct(SousDossierStringGetter $stringGetter)
    {
        $this->stringGetter = $stringGetter;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePunition', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date de punition : ',
                'html5' => true,
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'placeholder' => 'Selectionner une date'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('motif', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'required' => true,
                'label' => 'Motif de la punition : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('resume', CKEditorType::class, array(
                'label' => 'Expose des faits : ',
                'config' => array(
                    'uiColor' => '#ffffff',
                    'language' => 'fr',
                    'input_sync' => true,
                ),
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ]

            ))
            ->add('dureeDemade',IntegerType::class, [
                'required' => true,
                'label' => 'Duree de la punition : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('militairesDemandeurs', EntityType::class, [
                'class' => Militaire::class,
                'multiple' => true,
                'label' => 'Demandeur : ',
                'choice_label' => function (Militaire $militaire) {
                    return $militaire->getNom() .' '.$militaire->getPrenoms(). ' (' . $militaire->getMatricule().')';
                },
                'placeholder' => 'Choisir un militaire'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Punition::class,
        ]);
    }
}
