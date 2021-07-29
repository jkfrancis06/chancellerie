<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\GradeCategorie;
use App\Entity\Militaire;
use App\Entity\OrigineRecrutement;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MilitaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fichiers',FileType::class, [
                'label' => 'Logo',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                'multiple' => true,

                // make it optional so you don't have to re-upload the  file
                // every time you edit details
                'required' => false,

                'attr'     => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple',
                    'mimeTypesMessage' => "Veuillez uploader un fichier image valide",
                    'maxSizeMessage' => "Taille maximum de 1M",
                ],

            ])
            ->add('matricule', TextType::class, [
                'required' => true,
                'label' => 'Matricule : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('prenoms', TextType::class, [
                'required' => true,
                'label' => 'Prenoms : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'required' => true,
                'label' => 'Date de naissance: ',
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
            ->add('sexe', ChoiceType::class, [
                'required' => true,
                'label' => 'Sexe : ',
                'choices'  => [
                    'Homme' => 'h',
                    'Femme' => 'f',
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])
            ->add('taille',NumberType::class,[
                'required' => true,
                'label' => 'Taille : ',
                'attr' => array(
                    'placeholder' => 'Taille en metre. Exemple: 1.3'
                ),
                'constraints' => [
                    new Regex("/^[1-3]+.[0-9]+$/",'La taille doit etre comprise entre 1 et 3 m')
                ]
            ])
            ->add('couleurYeux', TextType::class, [
                'required' => true,
                'label' => 'Couleur des yeux : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('situationMatri', ChoiceType::class, [
                'required' => true,
                'label' => 'Situation matrimoniale : ',
                'choices'  => [
                    'Celibataire' => 'h',
                    'Marie' => 'f',
                    'Divorce' => 'f',
                ],
                'constraints' => [
                    new NotBlank()
                ],
            ])


            ->add('hasChildren', ChoiceType::class, [
                'required' => true,
                'label' => 'Situation familiale : ',
                'choices'  => [
                    'Sans enfant' => false,
                    'Avec enfant' => true,
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])


            ->add('adresse', TextType::class, [
                'required' => true,
                'label' => 'Adresse : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])

            ->add('telephone', TextType::class, [
                'required' => true,
                'label' => 'Numeros de telephones : ',
                'mapped' => false,
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Saisir plusieurs numeros de telephones separes par des point-virgules'
                ],

            ])

            ->add('dateIncorp', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date d\'incorporation : ',
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


            ->add('professionAnt', TextType::class, [
                'label' => 'Profession anterieure : ',
            ])


            ->add('grade', EntityType::class, [
                'class' => Grade::class,
                'label' => 'Grade : ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir un grade'
            ])


            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'label' => 'Specialite : ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une specialite'
            ])


            ->add('origineRecrutement', EntityType::class, [
                'class' => OrigineRecrutement::class,
                'label' => 'Origine de recrutement: ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une origine de recrutement'
            ])

            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Militaire::class,
        ]);
    }
}