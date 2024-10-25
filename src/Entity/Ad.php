<?php

namespace App\Entity;

use App\Enum\AdType;
use App\Enum\AdStatus;
use Doctrine\DBAL\Types\Types;
use App\Repository\AdRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AdRepository::class)]
class Ad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ad:detail'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['ad:detail'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['ad:detail'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['ad:detail'])]
    private ?int $price = null;

    #[ORM\Column]
    #[Groups(['ad:detail'])]
    private ?int $surface = null;

    #[ORM\Column(enumType: AdType::class)]
    #[Groups(['ad:detail'])]
    private ?AdType $type = null;

    #[ORM\Column(enumType: AdStatus::class)]
    #[Groups(['ad:detail'])]
    private ?AdStatus $status = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ad:detail'])]
    private ?string $address = null;

    #[ORM\Column(length: 5)]
    #[Groups(['ad:detail'])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 100)]
    #[Groups(['ad:detail'])]
    private ?string $city = null;

    #[ORM\Column]
    #[Groups(['ad:detail'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['ad:detail'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ad:detail'])]
    private ?Agence $agence = null;

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

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getType(): ?AdType
    {
        return $this->type;
    }

    public function setType(AdType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?AdStatus
    {
        return $this->status;
    }

    public function setStatus(AdStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): static
    {
        $this->agence = $agence;

        return $this;
    }
}
