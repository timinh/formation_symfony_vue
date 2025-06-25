<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['status.read', 'task:read']],
    operations: [
        new GetCollection()
    ]
)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['status.read', 'task:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['status.read', 'task:read'])]
    private ?string $libelle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }
}
