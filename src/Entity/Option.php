<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $name = null;

    #[ORM\Column(length: 60)]
    private ?string $type = null;

    /**
     * @var Collection<int, AdOption>
     */
    #[ORM\OneToMany(targetEntity: AdOption::class, mappedBy: 'choice')]
    private Collection $adOptions;

    public function __construct()
    {
        $this->adOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, AdOption>
     */
    public function getAdOptions(): Collection
    {
        return $this->adOptions;
    }

    public function addAdOption(AdOption $adOption): static
    {
        if (!$this->adOptions->contains($adOption)) {
            $this->adOptions->add($adOption);
            $adOption->setChoice($this);
        }

        return $this;
    }

    public function removeAdOption(AdOption $adOption): static
    {
        if ($this->adOptions->removeElement($adOption)) {
            // set the owning side to null (unless already changed)
            if ($adOption->getChoice() === $this) {
                $adOption->setChoice(null);
            }
        }

        return $this;
    }
}
