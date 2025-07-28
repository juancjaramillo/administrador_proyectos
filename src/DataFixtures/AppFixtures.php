<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\UserProjectRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear usuarios
        $user1 = new User();
        $user1->setName('Alicia Martinez');
        $user1->setEmail('alicia@admindemo.com');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setName('Juan Jaramillo');
        $user2->setEmail('juan@admindemo.com');
        $manager->persist($user2);

        // Crear proyectos
        $project1 = new Project();
        $project1->setName('Proyecto Symfony');
        $project1->setDescription('Sistema Symfony con tareas y tarifas');
        $manager->persist($project1);

        $project2 = new Project();
        $project2->setName('Proyecto EmberJs');
        $project2->setDescription('Frontend moderno en Ember.js');
        $manager->persist($project2);

        // Tarifas por usuario-proyecto
        $rate1 = new UserProjectRate();
        $rate1->setUser($user1);
        $rate1->setProject($project1);
        $rate1->setHourlyRate(50);
        $manager->persist($rate1);

        $rate2 = new UserProjectRate();
        $rate2->setUser($user1);
        $rate2->setProject($project2);
        $rate2->setHourlyRate(60);
        $manager->persist($rate2);

        $rate3 = new UserProjectRate();
        $rate3->setUser($user2);
        $rate3->setProject($project1);
        $rate3->setHourlyRate(55);
        $manager->persist($rate3);

        // Tareas
        $task1 = new Task();
        $task1->setTitle('Implementar API');
        $task1->setDescription('Crear endpoints REST');
        $task1->setHours(5);
        $task1->setUser($user1);
        $task1->setProject($project1);
        $manager->persist($task1);

        $task2 = new Task();
        $task2->setTitle('Diseñar frontend');
        $task2->setDescription('Pantallas principales con Ember Js');
        $task2->setHours(8);
        $task2->setUser($user1);
        $task2->setProject($project2);
        $manager->persist($task2);

        $task3 = new Task();
        $task3->setTitle('Optimizar consultas SQL');
        $task3->setDescription('Optimización de queries pesadas');
        $task3->setHours(6);
        $task3->setUser($user2);
        $task3->setProject($project1);
        $manager->persist($task3);

        $manager->flush();
    }
}
