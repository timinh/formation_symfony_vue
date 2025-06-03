<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/project', name: 'app_project')]
    #[Route('/project/{actions}', name: 'app_projects_actions')]
    #[Route('/task/{actions}', name: 'app_task_actions')]
    #[Route('/status/{actions}', name: 'app_status_actions')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
