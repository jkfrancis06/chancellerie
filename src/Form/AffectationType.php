<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Corps;
use App\Entity\Grade;
use App\Entity\Piece;
use App\Entity\SousDossier;
use App\Entity\Unite;
use App\Service\SousDossierStringGetter;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class AffectationType extends AbstractType
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
                'label' => 'Date de mutation : ',
                'html5' => true,
                //'format' => 'dd-MM-yyyy',
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])

            ->add('fonction', TextType::class, [
                'required' => true,
                'label' => 'Adresse : ',
                'constraints' => [
                    new NotBlank()
                ]
            ])

            ->add('corps', EntityType::class, [
                'class' => Corps::class,
                'label' => 'Grade : ',
                'choice_label' => function (Corps $corps) {
                    return $corps->getDescription() . ' (' . $corps->getIntitule().')';
                },
                'placeholder' => 'Choisir un corps'
            ])

            ->add('addPiece', ChoiceType::class, [
                'choices'  => [
                    'Choisir une option' => null,
                    'Selectionner une piece depuis les archives' => 2,
                    'Creer une nouvelle piece' => 1,
                ]
            ])


            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;

        // grab the user, do a quick sanity check that one exists
        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException(
                'Must be authenticated!'
            );
        }

        $formModifier = function (FormInterface $form, Corps $corps = null) {
            $unites = null === $corps ? [] : $corps->getUnites();

            $form->add('unite', EntityType::class, [
                'class' => Unite::class,
                'label' => 'Unites : ',
                'choices' => $unites,
                'placeholder' => 'Choisir une unite'
            ]);
        };


        $pieceFormModifier = function (FormInterface $form, $data , $event) {

            if ($data == 1){
                $form->add('piece',PieceType::class);
            }elseif ($data == 2){
                $form->add('piece', EntityType::class, [
                    'class' => Piece::class,
                    'label' => 'Piece Archive : ',
                    'choice_label' => function (Piece $piece) {
                        return $this->stringGetter->getString($piece->getSousDossier()->getType()). ' / ' .$piece->getDescription();
                    },
                    'query_builder' => function (EntityRepository $er) use ($event) {
                        return $er->createQueryBuilder('p')
                            ->leftJoin('p.sousDossier', 'sd')
                            ->where('sd.militaire = :militaire')
                            ->andWhere('sd.type = :type')
                            ->setParameter('militaire',$event->getData()->getMilitaire())
                            ->setParameter('type',SousDossier::PIECE_MUTATIONS);
                    },
                    'placeholder' => 'Choisir une piece dans les archives'
                ]);
            }
        };


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier,$pieceFormModifier) {

            $form = $event->getForm();

            if (null !== $event->getData()->getPiece()) {
                // we don't need to add the friend field because
                // the message will be addressed to a fixed friend
                return;
            }

            $data = $event->getData();

            $formModifier($event->getForm(), $data->getCorps());

            $pieceFormModifier($event->getForm(), $data->getAddPiece() , $event->getForm());

            // create the field, this is similar the $builder->add()
            // field name, field type, field options

        });


        $builder->get('corps')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $corps = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $corps);
            }
        );


        $builder->get('addPiece')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($pieceFormModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $data = $event->getForm()->getData();


                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $pieceFormModifier($event->getForm()->getParent(), $data , $event->getForm()->getParent());
            }
        );




    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
