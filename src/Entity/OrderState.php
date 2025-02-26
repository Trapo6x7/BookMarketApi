<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\CategoryRepository;
use App\Repository\OrderStateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderStateRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['category:read']]),
        new GetCollection(normalizationContext: ['groups' => ['category:read']]),
        new Post(denormalizationContext: ['groups' => ['category:write']]),
        new Patch(denormalizationContext: ['groups' => ['category:write']]),
        new Delete(),
    ]
)]
class OrderState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read', 'order_state:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['order:read', 'order:write','order_state:read'])]
    private ?string $state = null;

    #[ORM\OneToOne(mappedBy: 'orderState', cascade: ['persist', 'remove'])]
    private ?Order $sale = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getSale(): ?Order
    {
        return $this->sale;
    }

    public function setSale(Order $sale): static
    {
        // set the owning side of the relation if necessary
        if ($sale->getOrderState() !== $this) {
            $sale->setOrderState($this);
        }

        $this->sale = $sale;

        return $this;
    }
}
