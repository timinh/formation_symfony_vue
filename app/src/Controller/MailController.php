<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\MailDto;
use App\Service\SendMailService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    #[Route('/mail')]
    public function index(SendMailService $mailService): Response
    {
        $mailContent = new MailDto();
        $mailContent->to = 'lylian@blaud.uca.fr';
        $mailContent->subject = 'Test de mail';
        $mailContent->body = 'Ceci est le corps du mail de test.';

        $mailService->sendMail($mailContent);

        return new Response('');
    }
}
