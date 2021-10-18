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
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
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
                    'Retraite' => MilitaireStatut::STATUT_RETRAITE,
                    'Radie' => MilitaireStatut::STATUT_RADIE,
                    'Permission longue-duree' => MilitaireStatut::STATUT_PERM_LD,
                    'En service' => MilitaireStatut::STATUT_SERVICE,
                    'Disponibilite' => MilitaireStatut::STATUT_DISPONIBILITE,
                    'Detachement' => MilitaireStatut::STATUT_DETACHEMENT,
                    'Deserteur' => MilitaireStatut::STATUT_DESERTEUR,
                    'Absence' => MilitaireStatut::STATUT_ABSENCE,
                    'Arret maladie' => MilitaireStatut::STATUT_ARR_MALADIE,
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
