<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ConditionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ConditionRepository::class)]
#[ORM\Table(name: '`condition`')]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['state:read']],
            security: "is_granted('PUBLIC_ACCESS')"
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['state:read']],
            security: "is_granted('PUBLIC_ACCESS')"
        ),
    ]
)]
class Condition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['state:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['state:read'])]
    private ?string $state = null;

    /**
     * @var Collection<int, Anounce>
     */
    #[ORM\OneToMany(targetEntity: Anounce::class, mappedBy: 'state', orphanRemoval: true)]
    private Collection $anounces;

    public function __construct()
    {
        $this->anounces = new ArrayCollection();
    }

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
            $anounce->setState($this);
        }

        return $this;
    }

    public function removeAnounce(Anounce $anounce): static
    {
        if ($this->anounces->removeElement($anounce)) {
            // set the owning side to null (unless already changed)
            if ($anounce->getState() === $this) {
                $anounce->setState(null);
            }
        }

        return $this;
    }
}
