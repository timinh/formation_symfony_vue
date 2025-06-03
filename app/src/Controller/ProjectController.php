<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ProjectController extends AbstractController
{

    #[Route('/project', name: 'app_project')]
    public function index(ProjectRepository $pj): JsonResponse
    {
        $projects = $pj->findAll();

        return $this->json(
            $projects,
            Response::HTTP_OK,
            [],
            ['groups' => 'project:read']
        );
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
