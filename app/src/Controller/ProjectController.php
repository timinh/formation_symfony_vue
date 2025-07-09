<?php

namespace App\Controller;

use App\Entity\Project;
use App\Message\PrintTasksMessage;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ProjectController extends AbstractController
{

    #[Route('/project/{project}', name: 'app_project_show')]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'title' => 'Project Details',
            'project' => $project,
        ]);
    }

    #[Route('/project/{project}/print-tasks', name: 'app_project_print')]
    public function printTasks(Project $project, MessageBusInterface $bus): Response
    {
        $bus->dispatch(
            new PrintTasksMessage(
                projectId: $project->getId()
            )
        );
        return new JsonResponse([
            'message' => 'Impression du projet ' . $project->getTitle() . ' en cours.',
            'projectId' => $project->getId(),
        ]);
    }
}
