<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SendMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MailController extends AbstractController
{
    #[Route('/mail')]
    public function index(SendMailService $mailService): Response
    {
        $mailService->sendMail('lylian.blaud@uca.fr', 'Test Mail', 'This is a test mail body.');

        return new Response('');
    }
}
