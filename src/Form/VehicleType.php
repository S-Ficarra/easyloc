<?php

namespace App\Form;

use App\Document\VehicleDocument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('licencePlate', TextType::class, [
                'label' => 'Plaque D\'immatriculation'
            ])
            ->add('informations', TextareaType::class, [
                'label' => 'Informations sur le véhicule'
            ])
            ->add('km', IntegerType::class, [
                'label' => 'Kilométrage'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VehicleDocument::class,
        ]);
    }
}
