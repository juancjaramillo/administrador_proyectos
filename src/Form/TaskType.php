<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Tarea',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
                'attr' => ['rows' => 4],
            ])
            ->add('hours', NumberType::class, [
                'label' => 'Horas estimadas',
            ])
            ->add('hourlyRate', NumberType::class, [
                'label'    => 'Tarifa por hora',
                'required' => false,
                'attr'     => ['step' => '0.01'],
            ])
            ->add('user', EntityType::class, [
                'label'    => 'Usuario asignado',
                'class'        => User::class,
                'choice_label' => 'name',
                'placeholder'  => 'Selecciona un usuario',
            ])
            ->add('project', EntityType::class, [
                'label'    => 'Proyecto',
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
