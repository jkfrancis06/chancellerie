<?php

namespace App\Form;

use App\Entity\Militaire;
use App\Entity\MilitaireStatut;
use App\Entity\Unite;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class SpaStatType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period', DateType::class, [
                // adds a class that can be selected in JavaScript
                'required' => true,

                'html5' => true,
                'widget' => 'single_text',

                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'Selectionner une date'
                ],

            ])
            ->add('save', SubmitType::class, ['label' => 'Rechercher'])

        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event)  {

            $form = $event->getForm();


            if (in_array('ROLE_CHAN',$this->security->getUser()->getRoles())) {
                $form->add('unite', EntityType::class, [
                    'class' => Unite::class,
                    'multiple' => true,
                    'required' => false,
                ]);
            }else{
                $form->add('unite', EntityType::class, [
                    'class' => Unite::class,
                    'multiple' => true,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) use ($event) {
                        $qb =  $er->createQueryBuilder('u');
                        $qb->leftJoin("u.corps", "c");
                        if ($this->security->getUser()->getMilitaire() != null){
                            $qb->where("c.chefCorps = :chefCorps")
                                ->setParameter('chefCorps', $this->security->getUser()->getMilitaire() );
                        }
                        return $qb;
                    },
                ]);
            }





            // create the field, this is similar the $builder->add()
            // field name, field type, field options

        });



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
