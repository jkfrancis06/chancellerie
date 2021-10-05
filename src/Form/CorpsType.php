<?php

namespace App\Form;

use App\Entity\Corps;
use App\Entity\Militaire;
use App\Entity\MilitaireStatut;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class CorpsType extends AbstractType
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
            ->add('description', TextType::class, [
                'label' => 'Intitule',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('chefCorps', EntityType::class, [
                'class' => Militaire::class,
                'query_builder' => function (EntityRepository $er) {
                    $qb =  $er->createQueryBuilder('m');
                            $qb->leftJoin('m.militaireStatuts', 'ms')
                                ->where($qb->expr()->notin("ms.statut", ":statutArray"))
                                ->setParameter('statutArray',[
                                    MilitaireStatut::STATUT_DESERTEUR,
                                    MilitaireStatut::STATUT_RADIE,
                                    MilitaireStatut::STATUT_RADIE
                                ]);
                        return $qb;
                },
            ])

            ->add('mainPicture',FileType::class, [
                'label' => 'Logo',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                'multiple' => false,

                // make it optional so you don't have to re-upload the  file
                // every time you edit details
                'required' => false,

                'attr'     => [
                    'accept' => 'image/*',
                    'mimeTypesMessage' => "Veuillez uploader un fichier image valide",
                    'maxSizeMessage' => "Taille maximum de 1M",
                ],

            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Corps::class,
        ]);
    }
}
