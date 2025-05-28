<?php

namespace App\Controller;

use App\Service\Security\TokenService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PublicController extends AbstractController
{

    #[Route('/', name: 'app_public_vue')]
    #[Route('/project', name: 'app_project')]
    #[Route('/project/{id}', name: 'app_project_page')]
    public function indexVue(
        #[Autowire('%env(APP_SECRET)%')] string $app_secret,
        TokenService $jwt
    )
    {
        $payload = \json_encode([
            'user_id' => $this->getUser()->getUserIdentifier(),
            'roles' => $this->getUser()->getRoles()
        ]);
        $user_token = $jwt->generateToken($payload, $app_secret);
        
        return $this->render(
            'baseVue.html.twig',
            compact('user_token')
        );
    }

    #[Route('/old', name: 'app_public')]
    public function index(): Response
    {
        $testimonials = [
            [
                'name' => 'John Doe',
                'position' => 'CEO of Example Company',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            ],
            [
                'name' => 'Jane Smith',
                'position' => 'CTO of Example Company',
                'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            ]
        ];

        return $this->render('public/index.html.twig', [
            'testimonials' => $testimonials,
        ]);
    }
}
