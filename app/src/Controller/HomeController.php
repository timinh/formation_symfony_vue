<?php

namespace App\Controller;

use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

final class HomeController extends AbstractController
{
    public function __construct(
        private HubInterface $hub
    ) {}

    private function getJWTToken(JWTTokenManagerInterface $jwtTokenManager): string
    {
        return $jwtTokenManager->create($this->getUser());
    }


    #[Route('/', name: 'app_home')]
    #[Route('/unauthorized', name: 'app_unauthorized')]
    #[Route('/project', name: 'app_project')]
    #[Route('/project/{actions}', name: 'app_projects_actions')]
    #[Route('/task/{actions}', name: 'app_task_actions')]
    #[Route('/status/{actions}', name: 'app_status_actions')]
    public function index(JWTTokenManagerInterface $jwtTokenManager): Response
    {
        $this->connectdUser();
        return $this->render(
            'base.html.twig',
            ['user_token' => $this->getJWTToken($jwtTokenManager)]
        );
    }

    #[Route('/about', name: 'app_about')]
    public function about(
        JWTTokenManagerInterface $jwtTokenManager,
        HubInterface $hub
    ): Response
    {
        // Publish a message to the Mercure hub
        $update = new Update(
            'see_about',
            json_encode(['username' => $this->getUser()->getUserIdentifier()])
        );
        $hub->publish($update);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user_token' => $this->getJWTToken($jwtTokenManager),
        ]);
    }

    private function connectdUser(): void
    {
        // Publish a message to the Mercure hub
        $update = new Update(
            'connected_users',
            json_encode([
                'username' => $this->getUser()->getUserIdentifier(),
                'connected_at' => (new \DateTime())->format('H:i:s')
            ])
        );
        $this->hub->publish($update);
    }
}
