<?php

namespace App\Form;

use App\Entity\Indice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Indice1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('echelon')
            ->add('indice')
            ->add('anciennete')
            ->add('prerequation')
            ->add('periodeAnciennete')
            ->add('grade')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Indice::class,
        ]);
    }
}
