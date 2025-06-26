<?php

namespace App\Service;

use App\Dto\MailDto;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class SendMailService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        #[Autowire('%env(FROM_MAIL)%')] private readonly string $fromEmail
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail(MailDto $mailContent): void
    {
        $email = new TemplatedEmail();
        $email
            ->from($this->fromEmail)
            ->to($mailContent->to)
            ->subject($mailContent->subject)
            ->htmlTemplate('emails/template.html.twig')
            ->context([
                'body' => $mailContent->body,
            ]);

        $this->mailer->send($email);
    }
}
