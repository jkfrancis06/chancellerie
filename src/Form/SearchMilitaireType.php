<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\OrigineRecrutement;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SearchMilitaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom : ',
                'required' => false,

            ])
            ->add('prenoms', TextType::class, [
                'label' => 'Prenoms : ',
                'required' => false,

            ])
            ->add('dateNaissance', TextType::class, [
                // adds a class that can be selected in JavaScript
                'required' => false,

                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],

            ])
            ->add('matricule', TextType::class, [
                'required' => false,

                'label' => 'Matricule : '
            ])
            ->add('sexe', ChoiceType::class, [

                'required' => false,
                'label' => 'Sexe : ',
                'choices'  => [
                    'Selectionner' => null,
                    'Homme' => 'h',
                    'Femme' => 'f',
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])
            ->add('taille', TextType::class, [
                'required' => false,
                'attr' => [
                    'readonly' => true,
                ]
            ])
            ->add('couleurYeux', TextType::class, [
                'required' => false,
                'label' => 'Couleur des yeux : ',
            ])
            ->add('situationMatri', ChoiceType::class, [
                'required' => false,
                'label' => 'Situation matrimoniale : ',
                'multiple' => true,
                'choices'  => [
                    'Selectionner' => null,
                    'Celibataire' => 'Celibataire',
                    'Marie' => 'Marie',
                    'Divorce' => 'Divorce',
                ]
            ])
            ->add('hasChildren', ChoiceType::class, [
                'required' => false,
                'label' => 'Situation familiale : ',
                'choices'  => [
                    'Selectionner' => null,
                    'Sans enfant' => false,
                    'Avec enfant' => true,
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])

            ->add('adresse', TextType::class, [
                'required' => false,
                'label' => 'Adresse : ',
            ])

            ->add('telephone', TextType::class, [
                'required' => false,
                'label' => 'Numeros de telephones : ',
                'attr' => [
                    'placeholder' => 'Saisir plusieurs numeros de telephones separes par des point-virgules'
                ],

            ])

            ->add('dateIncorp', TextType::class, [
                // adds a class that can be selected in JavaScript
                'required' => false,

                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],

            ])

            ->add('professionAnt', TextType::class, [
                'required' => false,
                'label' => 'Profession anterieure : ',
            ])


            ->add('grade', EntityType::class, [
                'required' => false,
                'class' => Grade::class,
                'multiple' => true,
                'label' => 'Grade : ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir un grade'
            ])


            ->add('specialite', EntityType::class, [
                'required' => false,
                'class' => Specialite::class,
                'multiple' => true,
                'label' => 'Specialite : ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une specialite'
            ])


            ->add('origineRecrutement', EntityType::class, [
                'required' => false,
                'class' => OrigineRecrutement::class,
                'multiple' => true,
                'data' => null,
                'label' => 'Origine de recrutement: ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une origine de recrutement'
            ])

            ->add('submit', SubmitType::class, ['label' => 'Rechercher'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
