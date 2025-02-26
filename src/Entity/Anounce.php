<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use App\DataPersister\BookDataPersister;
use App\Repository\AnounceRepository;
use App\Repository\BookRepository;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnounceRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['anounce:read']],
            security: "is_granted('PUBLIC_ACCESS')"
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['anounce:read']],
            security: "is_granted('PUBLIC_ACCESS')"
        ),
        new Post(
            denormalizationContext: ['groups' => ['anounce:write']],
            security: "is_granted('ROLE_USER')",
            processor: BookDataPersister::class,
            securityMessage: "Seuls les utilisateurs connectés peuvent créer des livres"
        ),
        new Patch(
            denormalizationContext: ['groups' => ['anounce:write']],
            security: "is_granted('ANOUNCE_EDIT', object)",
            securityMessage: "Vous ne pouvez modifier que vos propres livres"
        ),
        new Delete(
            security: "is_granted('ANOUNCE_DELETE', object)",
            securityMessage: "Vous ne pouvez supprimer que vos propres livres"
        ),
    ]
)]
class Anounce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['anounce:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'anounce', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['anounce:read', 'anounce:write'])]
    private ?Book $book = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['anounce:read', 'anounce:write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['anounce:read', 'anounce:write'])]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    #[Groups(['anounce:read', 'anounce:write'])]
    private ?string $imageUrl = null;

    #[ORM\ManyToOne(inversedBy: 'anounces')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['anounce:read', 'anounce:write'])]
    private ?Condition $state = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getState(): ?Condition
    {
        return $this->state;
    }

    public function setState(?Condition $state): static
    {
        $this->state = $state;

        return $this;
    }
}
