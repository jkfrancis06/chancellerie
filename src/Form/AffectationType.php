<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Grade;
use App\Entity\Piece;
use App\Entity\Unite;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class AffectationType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date de mutation : ',
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
            ->add('dateFin', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label' => 'Date de fin de mutation : ',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],
            ])
            ->add('fonction', TextType::class, [
                'required' => true,
                'label' => 'Adresse : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('unite', EntityType::class, [
                'class' => Unite::class,
                'label' => 'Grade : ',
                'choice_label' => function (Unite $unite) {
                    return $unite->getIntitule() . ' / ' . $unite->getCorps()->getIntitule();

                    // or better, move this logic to Customer, and return:
                    // return $customer->getFullname();
                },
                'placeholder' => 'Choisir une unite'
            ])

            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;

        // grab the user, do a quick sanity check that one exists
        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
            if (null !== $event->getData()->getPiece()) {
                // we don't need to add the friend field because
                // the message will be addressed to a fixed friend
                return;
            }

            $form = $event->getForm();



            // create the field, this is similar the $builder->add()
            // field name, field type, field options
            $form->add('piece', EntityType::class, [
                'class' => Piece::class,
                'label' => 'Piece Archive : ',
                'choice_label' => function (Piece $piece) {
                    return $piece->getSousDossier()->getNumero() . '-' . $piece->getNumeroOrdre(). ' : ' .$piece->getDescription();
                },
                'query_builder' => function (EntityRepository $er) use ($event) {
                    return $er->createQueryBuilder('p')
                        ->select('p')
                        ->join('p.sousDossier', 's')
                        ->addSelect('s')
                        ->from('App\Entity\SousDossier', 'p')
                        ->join('p.sousDossier', 'ss')
                        ->leftJoin('ss.militaire', 'm')
                        ->addSelect('m')
                        ->where('m.id = :id')
                        ->setParameter('id',$event->getData()->getMilitaire()->getId());
                },
                'placeholder' => 'Choisir une piece dans les archives'
            ]);
        });

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
