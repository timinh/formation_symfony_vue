<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(ProjectRepository $pj): Response
    {
        $projects = $pj->findAll();
        return $this->render('project/index.html.twig', [
            'title' => 'Ma page projets',
            'projects' => $projects,
        ]);
    }

    #[Route('/project/{project}', name: 'app_project_show')]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'title' => 'Project Details',
            'project' => $project,
        ]);
    }
}
