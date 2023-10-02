<?php

namespace App\Form;

use App\Entity\Hoursworked;
use App\Entity\Employees;
use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HoursworkedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('employee', EntityType::class, [
                'class' => Employees::class,
                'choice_label' => function (Employees $employee) {
                    return $employee->getFirstname() . ' ' . $employee->getLastname();
                }, 
                'label' => 'Employé :',
                'required' => true, 
                'attr' => ['class' => 'form-select form-select-sm']
            ])
            ->add('mission', EntityType::class, [
                'class' => Missions::class,
                'choice_label' => 'objective', 
                'label' => 'Mission :',
                'required' => true, 
                'attr' => ['class' => 'form-select form-select-sm']
            ])
            ->add('period',  TextType::class, [
                'label' => 'Période :',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
            ->add('numberHours', NumberType::class, [
                'label' => 'Nombre d\'heures:',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
            ->add('workDays',  DateType::class, [
                'label' => 'Jour de travail:',
                'required' => true, 
                'attr' => ['class' => 'form-control form-control-sm']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hoursworked::class,
        ]);
    }
}
