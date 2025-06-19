<?php

namespace App\Dto;

use ApiPlatform\Metadata\Post;
use App\State\MailProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(input: MailDto::class, output: MailDto::class, processor: MailProcessor::class)]
class MailDto
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    public string $to;
    
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 180)]
    public string $subject;
    
    #[Assert\NotBlank]
    public string $body;

    public function getEmail(): string
    {
        return $this->to;
    }
}