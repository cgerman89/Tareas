<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
class TaskController extends AbstractController
{
   
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);

        $tasks = $task_repo->findBy([],['id' => 'DESC']);

        $eme = $this->getDoctrine()->getmanager();
        $user_repo = $this->getDoctrine()->getRepository(User::class);

        $users = $user_repo->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
