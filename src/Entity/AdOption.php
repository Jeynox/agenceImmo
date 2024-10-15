<?php

namespace App\Entity;

use App\Repository\AdOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdOptionRepository::class)]
class AdOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $value = [];

    #[ORM\ManyToOne(inversedBy: 'adOptions')]
    private ?Ad $ad = null;

    #[ORM\ManyToOne(inversedBy: 'adOptions')]
    private ?Option $choice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): static
    {
        $this->ad = $ad;

        return $this;
    }

    public function getChoice(): ?Option
    {
        return $this->choice;
    }

    public function setChoice(?Option $choice): static
    {
        $this->choice = $choice;

        return $this;
    }
}
