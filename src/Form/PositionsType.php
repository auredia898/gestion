<?php

namespace App\Form;

use App\Entity\Positions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class PositionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Type:',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
            ->add('hourlyRate', NumberType::class, [
                'label' => 'Taux horaire :',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Positions::class,
        ]);
    }
}
