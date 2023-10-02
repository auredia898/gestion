<?php

namespace App\Form;

use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objective', TextType::class, [
                'label' => 'Objectif:',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début:',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin:',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
