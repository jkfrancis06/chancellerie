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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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

            ->add('mainPicture',FileType::class, [
                'label' => 'Photo principale',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                'multiple' => false,

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
            ->add('matricule', IntegerType::class, [
                'required' => true,
                'label' => 'Matricule : ',
                'constraints' => [
                    new NotBlank()
                ],
                'validation_groups'=> $options['validation_groups']
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
                'html5' => true,
                'widget' => 'single_text',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'placeholder' => 'Selectionner une date'
                ],

                'constraints' => [
                    new NotBlank()
                ]

            ])

            ->add('lieuNaissance', TextType::class, [
                'label' => 'Lieu de naissance : ',
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
            ->add('groupeSanguin', ChoiceType::class, [
                'required' => false,
                'label' => 'Groupe Sanguin : ',
                'choices'  => [
                    'Selectionner' => null,
                    'O+' => 'O+',
                    'O-' => 'O-',
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'O-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                ],
                'attr' => [
                    'placeholder' => 'Selectionner'
                ],
            ])
            ->add('taille',NumberType::class,[
                'required' => false,
                'label' => 'Taille : ',
                'attr' => array(
                    'placeholder' => 'Taille en metre. Exemple: 1.3'
                ),
                'constraints' => [
                    new Regex("/^[1-3]+.[0-9]+$/",'La taille doit etre comprise entre 1 et 3 m')
                ]
            ])
            ->add('couleurYeux', TextType::class, [
                'required' => false,
                'label' => 'Couleur des yeux : ',

            ])
            ->add('situationMatri', ChoiceType::class, [
                'required' => true,
                'label' => 'Situation matrimoniale : ',
                'choices'  => [
                    'Celibataire' => 'Celibataire',
                    'Marie' => 'Marie',
                    'Divorce' => 'Divorce',
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
                'html5' => true,
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'placeholder' => 'Selectionner une date'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])


            ->add('professionAnt', TextType::class, [
                'required' => false,
                'label' => 'Profession anterieure : ',
            ])


            ->add('grade', EntityType::class, [
                'required' => true,
                'class' => Grade::class,
                'label' => 'Grade : ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir un grade'
            ])


            ->add('specialite', EntityType::class, [
                'required' => false,
                'class' => Specialite::class,
                'label' => 'Specialite : ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une specialite'
            ])



            ->add('origineRecrutement', EntityType::class, [
                'required' => false,
                'class' => OrigineRecrutement::class,
                'label' => 'Origine de recrutement: ',
                'choice_label' => 'intitule',
                'placeholder' => 'Choisir une origine de recrutement'
            ])

            ->add('surnom', TextType::class, [
                'required' => false,
                'label' => 'Surnom : ',
            ])

            ->add('quartier', TextType::class, [
                'required' => false,
                'label' => 'Quartier : ',
            ])

            ->add('numCarte', TextType::class, [
                'required' => false,
                'label' => 'Numero de carte d\'identite : ',
            ])

            ->add('numPassport', TextType::class, [
                'required' => false,
                'label' => 'Numero de passport : ',
            ])

            ->add('permisConduireCiv', TextType::class, [
                'required' => false,
                'label' => 'Permis de conduire civil : ',
            ])

            ->add('permisConduireMil', TextType::class, [
                'required' => false,
                'label' => 'Permis de conduire militaire : ',
            ])

            ->add('nivInstruGen', TextType::class, [
                'required' => false,
                'label' => 'Niveau d\'instruction general : ',
            ])

            ->add('formTech', TextType::class, [
                'required' => false,
                'label' => 'Formation technique : ',
            ])

            ->add('languePar', TextType::class, [
                'required' => false,
                'label' => 'Langues parlees : ',
            ])

            ->add('langueEcr', TextType::class, [
                'required' => false,
                'label' => 'Langues ecrites : ',
            ])

            ->add('sports', TextType::class, [
                'required' => false,
                'label' => 'Sports partiques : ',
            ])

            ->add('lieuPermission', TextType::class, [
                'required' => false,
                'label' => 'Lieu de permission : ',
            ])

            ->add('sousDossiers', CollectionType::class, [
                'required' => false,
                'entry_type' => SousDossierType::class,
                'entry_options' => ['label' => false],
            ])

            ->add('personnePrev', PersonnePrevType::class)


            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Militaire::class,
            'validation_groups' => ''
        ]);
    }

    public function getBlockPrefix()
    {
        return 'MilitaireType';
    }
}
