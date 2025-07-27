<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('hours')
            // <-- Mueve aquí “Tarifa por hora”
            ->add('hourlyRate', NumberType::class, [
                'label'    => 'Tarifa por hora',
                'required' => false,
                'attr'     => ['step' => '0.01'],
            ])
            ->add('user', EntityType::class, [
                'class'        => User::class,
                'choice_label' => 'name',
                'placeholder'  => 'Selecciona un usuario',
            ])
            ->add('project', EntityType::class, [
                'class'        => Project::class,
                'choice_label' => 'name',
                'placeholder'  => 'Selecciona un proyecto',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
