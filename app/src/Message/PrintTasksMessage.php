<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('sync')]
final class PrintTasksMessage
{
    public function __construct(
        public readonly string $projectId
    ) {
    }
}
