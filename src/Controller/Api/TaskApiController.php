<?php

namespace App\Controller\Api;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TaskApiController extends AbstractController
{
    #[Route('/api/users/{id}/tasks', name: 'api_user_tasks', methods: ['GET'])]
    public function tasksByUser(int $id, TaskRepository $repo): JsonResponse
    {
        // 1) Busca todas las tareas de ese usuario
        $tasks = $repo->findBy(['user' => $id]);

        // 2) Transforma a un array “plano”
        $data = [];
        foreach ($tasks as $task) {
            // busco la tarifa para ESTE proyecto
            $rate = null;
            foreach ($task->getUser()->getUserProjectRates() as $r) {
                if ($r->getProject() === $task->getProject()) {
                    $rate = $r->getHourlyRate();
                    break;
                }
            }

            $data[] = [
                'id'          => $task->getId(),
                'title'       => $task->getTitle(),
                'project'     => $task->getProject()->getName(),
                'hours'       => $task->getHours(),
                'hourlyRate'  => $rate,
                'total'       => $rate !== null ? $task->getHours() * $rate : null,
            ];
        }

        // 3) Devuelve JsonResponse
        return $this->json($data);
    }
}
