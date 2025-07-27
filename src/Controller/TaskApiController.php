<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class TaskApiController extends AbstractController
{
    #[Route('/api/users/{id}/tasks', name: 'api_user_tasks', methods: ['GET'])]
    public function getUserTasks(
        int $id,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $taskRepository = $em->getRepository(Task::class);
        $rateRepository = $em->getRepository(\App\Entity\UserProjectRate::class);

        $tasks = $taskRepository->findBy(['user' => $user]);

        $data = [];

        foreach ($tasks as $task) {
            $project = $task->getProject();
            $rate = $rateRepository->findOneBy([
                'user' => $user,
                'project' => $project
            ]);

            $data[] = [
                'task_title' => $task->getTitle(),
                'project_name' => $project->getName(),
                'hours' => $task->getHours(),
                'hourly_rate' => $rate ? $rate->getHourlyRate() : null,
                'total' => $rate ? $rate->getHourlyRate() * $task->getHours() : null,
            ];
        }

        return $this->json($data);
    }

    #[Route('/users/{id}/tasks/view', name: 'user_tasks_view', methods: ['GET'])]
    public function viewUserTasks(
        int $id,
        EntityManagerInterface $em
    ): Response {
        $user = $em->getRepository(User::class)->find($id);

       if (!$user) {
    return $this->render('task/user_tasks.html.twig', [
        'user' => null,
        'tasks' => []
    ]);
}

        $tasks = $em->getRepository(Task::class)->findBy(['user' => $user]);
        $rateRepo = $em->getRepository(\App\Entity\UserProjectRate::class);

        $taskData = [];

        foreach ($tasks as $task) {
            $project = $task->getProject();
            $rate = $rateRepo->findOneBy([
                'user' => $user,
                'project' => $project
            ]);

            $hourlyRate = $rate ? $rate->getHourlyRate() : 0;

            $taskData[] = [
                'title' => $task->getTitle(),
                'project' => $project->getName(),
                'hours' => $task->getHours(),
                'rate' => $hourlyRate,
                'total' => $task->getHours() * $hourlyRate,
            ];
        }

        return $this->render('task/user_tasks.html.twig', [
            'user' => $user,
            'tasks' => $taskData
        ]);
    }
}
