<?php

namespace App\MessageHandler;

use App\Service\PdfService;
use App\Message\PrintTasksMessage;
use App\Repository\ProjectRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PrintTasksMessageHandler
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly PdfService $pdfService
    )
    {
    }

    public function __invoke(PrintTasksMessage $message): void
    {
        $project = $this->projectRepository->find($message->projectId);
        if (!$project) {
            return;
        }

        $this->pdfService->generatePdf($project);
    }
}
