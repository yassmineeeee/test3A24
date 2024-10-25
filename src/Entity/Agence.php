<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $local = null;

    /**
     * @var Collection<int, annone>
     */
    #[ORM\OneToMany(targetEntity: annone::class, mappedBy: 'agence', orphanRemoval: true)]
    private Collection $annone;

    public function __construct()
    {
        $this->annone = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getLocal(): ?string
    {
        return $this->local;
    }

    public function setLocal(string $local): static
    {
        $this->local = $local;

        return $this;
    }

    /**
     * @return Collection<int, annone>
     */
    public function getAnnonces(): Collection
    {
        return $this->annone;
    }

    public function addAnnonces(annone $annone): static
    {
        if (!$this->annone->contains($annone)) {
            $this->annone->add($annone);
            $annone->setAgence($this);
        }

        return $this;
    }

    public function removeAnnonces(annone $annone): static
    {
        if ($this->annone->removeElement($annone)) {
            // set the owning side to null (unless already changed)
            if ($annone->getAgence() === $this) {
                $annone->setAgence(null);
            }
        }

        return $this;
    }
}
