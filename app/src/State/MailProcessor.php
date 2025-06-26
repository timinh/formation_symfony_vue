<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Service\SendMailService;

class MailProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly SendMailService $sendMailService
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $this->sendMailService->sendMail($data);
        return $data;
    }
}