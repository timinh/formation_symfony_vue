<?php

namespace App\Service;

use Twig\Environment;
use App\Entity\Project;
use Symfony\Component\Filesystem\Filesystem;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class PdfService
{
    public function __construct(
        private readonly DompdfWrapperInterface $wrapper,
        private readonly Environment $twig,
        #[Autowire("%kernel.project_dir%")]
        private readonly string $projectDir,
        private readonly HubInterface $hub,
    ) {
    }

    public function generatePdf(Project $project): void
    {
        $print_start = new Update(
            'project_print_start',
            json_encode(
                ['project_id' => $project->getId()]
            )
        );
        $this->hub->publish($print_start);

        $fs = new Filesystem();

        $htmlContent = $this->twig->render(
            'pdf/template.html.twig',
            [
                'project' => $project,
            ]
        );

        $this->wrapper->getPdf(
            $htmlContent
        );

        $fs->dumpFile(
            $this->projectDir . '/public/pdf/project_' . $project->getId(). '.pdf',
            $this->wrapper->getPdf($htmlContent)
        );

        $print_end = new Update(
            'project_print_end',
            json_encode(
                [
                    'project_id' => $project->getId(),
                    'pdf_path' => '/pdf/project_' . $project->getId() . '.pdf',
                ]
            )
        );
        \sleep(2);
        $this->hub->publish($print_end);
        
    }
}