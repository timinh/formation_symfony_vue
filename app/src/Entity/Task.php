<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['task:read', 'project:read']],
    operations: [
        new GetCollection()
    ]
)]
#[ApiFilter(NumericFilter::class, properties: ['project.id' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['start_date' => 'DESC'])]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['project:read', 'task:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['project:read', 'task:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['task:read'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $start_date = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $due_date = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['task:read'])]
    private ?Project $project = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['project:read'])]
    private ?Status $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getDueDate(): ?\DateTime
    {
        return $this->due_date;
    }

    public function setDueDate(?\DateTime $due_date): static
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }
}
