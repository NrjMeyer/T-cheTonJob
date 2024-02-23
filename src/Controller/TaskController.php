<?php

namespace App\Controller;

use App\Repository\TacheRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Tache;
use App\Entity\User;
use App\Form\TaskType;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_task')]
    public function index(TacheRepository $tacheRepository, UserRepository $userRepository): Response
    {
        $users = $userRepository
            ->findAll();

        $tasks = $tacheRepository
            ->findAll();

        return $this->render('task/all.html.twig', [
            'tasks' => $tasks,
            'users' => $users,
        ]);
    }

    #[Route('/task', name: 'ajax_task')]
    public function ajax(): JsonResponse
    {

        $tasks = $this->getDoctrine()
            ->getRepository(Tache::class)
            ->findAll();

        return $this->json([
            'message' => 'Success',
            'data' => $tasks,
        ]);
    }
    #[Route('/task/new', name: 'new_task')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $task = new Tache();
        $task->setCreatedAt(new \DateTime());
        $task->setUpdatedAt(new \DateTime());
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/task/{id}/edit', name: 'edit_task')]
    public function edit(EntityManagerInterface $entityManager, Request $request, Tache $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUpdatedAt(new \DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/task/{id}/delete', name: 'delete_task')]
    public function delete(EntityManagerInterface $entityManager, Tache $task): Response
    {
        $entityManager->remove($task);
        $entityManager->flush();

        return new Response(null, 204);
    }
}
