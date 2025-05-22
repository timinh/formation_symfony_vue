<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectForm;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly EntityManagerInterface $entityManager
    ){
    }

    #[Route('/project', name: 'app_project', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $this->projectRepository->findAll()
        ]);
    }

    #[Route('/project/create', name: 'app_project_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectForm::class, $project);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $this->entityManager->persist($project);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_project');
        }

        return $this->render('project/form_create_edit.html.twig', [
            'titleForm' => 'Créer un projet',
            'form' => $form
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project
        ]);
    }

    #[Route('/project/{id}/delete', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Project $project): Response
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_project');
    }

    #[Route('/project/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectForm::class, $project);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_project');
        }

        return $this->render('project/form_create_edit.html.twig', [
            'titleForm' => 'Modifier un projet',
            'form' => $form
        ]);
    }
}
