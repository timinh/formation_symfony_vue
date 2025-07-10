<?php

namespace App\Command;

use App\Dto\MailDto;
use App\Repository\TaskRepository;
use App\Service\SendMailService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsCommand(
    name: 'app:send-mail',
    description: 'Add a short description for your command',
)]
class SendMailCommand extends Command
{
    public function __construct(
        private readonly SendMailService $sendMailService,
        private readonly TaskRepository $taskRepository,
        #[Target('task_status')]
        private readonly WorkflowInterface $taskWorkflow
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $tasks = $this->taskRepository->findBy(['status' => 'En cours']);

        foreach ($tasks as $task) {
            if($task->getUser()) {

                try {
                    $this->taskWorkflow->apply($task, 'end_task');
                } catch (\LogicException $e) {
                    $io->error($e);
                    return Command::FAILURE;
                }

                $this->taskRepository->add($task);
            }
        }
        $io->success('Mail envoyé avec succès !');

        return Command::SUCCESS;
    }
}
