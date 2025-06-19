<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

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
    public function sendMail(string $to, string $subject, string $body): void
    {
        $email = new TemplatedEmail();
        $email
            ->from($this->fromEmail)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate('emails/template.html.twig')
            ->context([
                'body' => $body,
            ]);

        $this->mailer->send($email);
    }
}
