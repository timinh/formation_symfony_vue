<?php

namespace App\EventSubscriber;

use App\Dto\MailDto;
use App\Service\SendMailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Workflow\Event\TransitionEvent;

class TaskWorkflowSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly SendMailService $sendMailService
    ) {}

    /**
     * @throws TransportExceptionInterface
     */
    public function onWorkflowTransition(TransitionEvent $event): void
    {
        $task = $event->getSubject();
        $mail = new MailDto();
        $mail->to = $task->getUser()->getUsername().'@uca.fr';
        $mail->subject = 'Tâche en retard !';
        $mail->body = 'Attention, la date de la tâche : '.$task->getTitle().' est dépassée. Le status a été changé : '. $task->getStatus();
        $this->sendMailService->sendMail($mail);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.task_status.transition.end_task' => 'onWorkflowTransition',
        ];
    }
}
