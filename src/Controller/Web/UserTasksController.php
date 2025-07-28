<?php

namespace App\Controller\Web;

use App\Repository\UserRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UserTasksController extends AbstractController
{
    #[Route('/users/{id}/tasks/view', name: 'user_tasks_view', methods: ['GET'])]
    public function __invoke(
        int $id,
        UserRepository $userRepo,
        TaskRepository $taskRepo
    ): Response {
        $user = $userRepo->find($id);
        if (!$user) {
            return $this->render('task/user_tasks.html.twig', [
                'user'  => null,
                'tasks' => [],
            ]);
        }

        $tasks = $taskRepo->findBy(['user' => $user]);

        return $this->render('task/user_tasks.html.twig', [
            'user'  => $user,
            'tasks' => $tasks,
        ]);
    }
}
