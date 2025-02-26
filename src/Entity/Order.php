<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'purchase', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $buyer = null;

    #[ORM\OneToOne(inversedBy: 'sale', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $seller = null;

    #[ORM\OneToOne(inversedBy: 'sale', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $purchaseAt = null;

    #[ORM\OneToOne(inversedBy: 'sale', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderState $orderState = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(User $buyer): static
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(User $seller): static
    {
        $this->seller = $seller;

        return $this;
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

    public function getPurchaseAt(): ?\DateTimeImmutable
    {
        return $this->purchaseAt;
    }

    public function setPurchaseAt(\DateTimeImmutable $purchaseAt): static
    {
        $this->purchaseAt = $purchaseAt;

        return $this;
    }

    public function getOrderState(): ?OrderState
    {
        return $this->orderState;
    }

    public function setOrderState(OrderState $orderState): static
    {
        $this->orderState = $orderState;

        return $this;
    }
}
