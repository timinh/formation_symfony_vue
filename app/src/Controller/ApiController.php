<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/test_api', name: 'app_api')]
final class ApiController extends AbstractController
{
    #[Route('/', name: 'app_api_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository, SerializerInterface $serializer): JsonResponse
    {
        $projects = $projectRepository->getLastProjects(10);
        return $this->json($projects, 200, [], ['groups' => 'project:read']);
    }
}
