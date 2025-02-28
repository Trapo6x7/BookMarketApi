<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\DataPersister\UserDataPersister;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\Get;
use App\State\Provider\MeProvider;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/register',
            denormalizationContext: ['groups' => ['user:write']],
            validationContext: ['groups' => ['Default']],
            security: "is_granted('PUBLIC_ACCESS')",
            processor: UserDataPersister::class
        ),
        new Get(
            uriTemplate: '/me',
            normalizationContext: ['groups' => ['user:read']],
            security: "is_granted('ROLE_USER')",
            provider: MeProvider::class
        )
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user:write'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user:write'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:write'])]
    private ?string $password = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'user')]
    private Collection $books;

    #[ORM\Column(length: 255)]
    #[Groups(['user:write'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:write'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:write'])]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:write'])]
    private ?string $companyAdress = null;

    #[ORM\Column(length: 255, nullable: true)]
      #[Groups(['user:write'])]
    private ?string $companyName = null;


    /**
     * @var Collection<int, Anounce>
     */
    #[ORM\OneToMany(targetEntity: Anounce::class, mappedBy: 'seller', orphanRemoval: true)]
    private Collection $anounces;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'buyer', orphanRemoval: true)]
    private Collection $orders;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'seller', orphanRemoval: true)]
    private Collection $orderAsSeller;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'buyer', orphanRemoval: true)]
    private Collection $ordersAsBuyer;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $articles;



    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->anounces = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->orderAsSeller = new ArrayCollection();
        $this->ordersAsBuyer = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setUser($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getUser() === $this) {
                $book->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getCompanyAdress(): ?string
    {
        return $this->companyAdress;
    }

    public function setCompanyAdress(?string $companyAdress): static
    {
        $this->companyAdress = $companyAdress;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }



    /**
     * @return Collection<int, Anounce>
     */
    public function getAnounces(): Collection
    {
        return $this->anounces;
    }

    public function addAnounce(Anounce $anounce): static
    {
        if (!$this->anounces->contains($anounce)) {
            $this->anounces->add($anounce);
            $anounce->setSeller($this);
        }

        return $this;
    }

    public function removeAnounce(Anounce $anounce): static
    {
        if ($this->anounces->removeElement($anounce)) {
            // set the owning side to null (unless already changed)
            if ($anounce->getSeller() === $this) {
                $anounce->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setBuyer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getBuyer() === $this) {
                $order->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderAsSeller(): Collection
    {
        return $this->orderAsSeller;
    }

    public function addOrderAsSeller(Order $orderAsSeller): static
    {
        if (!$this->orderAsSeller->contains($orderAsSeller)) {
            $this->orderAsSeller->add($orderAsSeller);
            $orderAsSeller->setSeller($this);
        }

        return $this;
    }

    public function removeOrderAsSeller(Order $orderAsSeller): static
    {
        if ($this->orderAsSeller->removeElement($orderAsSeller)) {
            // set the owning side to null (unless already changed)
            if ($orderAsSeller->getSeller() === $this) {
                $orderAsSeller->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrdersAsBuyer(): Collection
    {
        return $this->ordersAsBuyer;
    }

    public function addOrdersAsBuyer(Order $ordersAsBuyer): static
    {
        if (!$this->ordersAsBuyer->contains($ordersAsBuyer)) {
            $this->ordersAsBuyer->add($ordersAsBuyer);
            $ordersAsBuyer->setBuyer($this);
        }

        return $this;
    }

    public function removeOrdersAsBuyer(Order $ordersAsBuyer): static
    {
        if ($this->ordersAsBuyer->removeElement($ordersAsBuyer)) {
            // set the owning side to null (unless already changed)
            if ($ordersAsBuyer->getBuyer() === $this) {
                $ordersAsBuyer->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }


}
