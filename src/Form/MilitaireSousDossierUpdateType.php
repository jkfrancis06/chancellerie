<?php

namespace App\Form;

use App\Entity\Militaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MilitaireSousDossierUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sousDossiers', CollectionType::class, [
                'required' => false,
                'entry_type' => SousDossierType::class,
                'entry_options' => ['label' => false],
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

    public function getBlockPrefix()
    {
        return 'MilitaireSousDossierUpdateType';
    }
}
