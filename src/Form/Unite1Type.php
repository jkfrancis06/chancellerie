<?php

namespace App\Form;

use App\Entity\Militaire;
use App\Entity\SousDossier;
use App\Entity\Unite;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Unite1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('description')
            ->add('corps')
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event)  {

            $form = $event->getForm();

            $form->add('chefFormation', EntityType::class, [
                'class' => Militaire::class,
                'query_builder' => function (EntityRepository $er) use ($event) {
                    return $er->createQueryBuilder('m')
                        ->leftJoin('m.affectations', 'a')
                        ->where('a.unite = :unite')
                        ->andWhere('a.isActive = :active')
                        ->setParameter('unite',$event->getData())
                        ->setParameter('active',true);
                },
            ]);

            // create the field, this is similar the $builder->add()
            // field name, field type, field options

        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Unite::class,
        ]);
    }
}
