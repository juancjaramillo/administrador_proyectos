<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task')]
#[IsGranted('ROLE_ADMIN')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'task_index', methods: ['GET'])]
    public function index(TaskRepository $repo): Response
    {
        $tasks = $repo->findAll();
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/new', name: 'task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'task_show', methods: ['GET'])]
    public function show(int $id, TaskRepository $repo): Response
    {
        $task = $repo->find($id);
        if (!$task) {
            throw $this->createNotFoundException('Tarea no encontrada');
        }

        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, TaskRepository $repo, EntityManagerInterface $em): Response
    {
        $task = $repo->find($id);
        if (!$task) {           
            return $this->render('task/edit.html.twig', [
                'task' => null,
            ]);
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('task_index');
    }

    /**
     * Vista web: listado de tareas de un usuario
     */
    #[Route('/users/{id}/tasks/view', name: 'user_tasks_view', methods: ['GET'])]
    public function userTasks(int $id, UserRepository $userRepo, TaskRepository $taskRepo): Response
    {
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
