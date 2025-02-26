<?php

namespace App\Entity;

use App\Repository\OrderStateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderStateRepository::class)]
class OrderState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
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
