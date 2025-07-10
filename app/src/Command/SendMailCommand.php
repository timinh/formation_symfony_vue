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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:send-mail',
    description: 'Add a short description for your command',
)]
class SendMailCommand extends Command
{
    public function __construct(private readonly SendMailService $sendMailService, private readonly TaskRepository $taskRepository)
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

        $tasks = $this->taskRepository->findTaskEnded(new \DateTime());

        foreach ($tasks as $task) {
            if($task->getUser()) {
                $mail = new MailDto();
                $mail->to = $task->getUser()->getUsername().'@uca.fr';
                $mail->subject = 'Tâche en retard !';
                $mail->body = 'Attention, la date de la tâche : '.$task->getTitle().' est dépassée.';
                $this->sendMailService->sendMail($mail);
            }
        }
        $io->success('Mail envoyé avec succès !');

        return Command::SUCCESS;
    }
}
