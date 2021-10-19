<?php

namespace App\Form;

use App\Entity\Militaire;
use App\Entity\MilitaireMission;
use App\Entity\Mission;
use App\Entity\Piece;
use App\Entity\SousDossier;
use App\Service\SousDossierStringGetter;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class MilitaireMissionEnrolType extends AbstractType
{

    private $security;
    private $stringGetter;

    public function __construct(Security $security, SousDossierStringGetter $stringGetter)
    {
        $this->security = $security;
        $this->stringGetter = $stringGetter;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date de debut : ',
                'html5' => true,
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'placeholder' => 'Selectionner une date'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('dateFin', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label' => 'Date de fin : ',
                'html5' => true,
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'placeholder' => 'Selectionner une date'
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire : ',
            ])
            ->add('militaire', EntityType::class, [
                'class' => Militaire::class,
                'label' => 'Grade : ',
                'choice_label' => function (Mission $mission) {
                    return $mission->getIntitule() . ' / ' . $mission->getLieu();

                },
                'placeholder' => 'Choisir une mission'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('cancel', ResetType::class, ['label' => 'Annuler'])
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MilitaireMission::class,
        ]);
    }
}
