<?php

namespace App\Entity;

use App\Repository\BibliothequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BibliothequeRepository::class)]
class Bibliotheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'bibliotheques')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'bibliotheque', targetEntity: LivreBibliotheque::class, cascade: ["persist"])]
    private Collection $livreBibliotheques;

    #[ORM\Column]
    private ?bool $modifiable = true;

    public function __construct()
    {
        $this->livreBibliotheques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LivreBibliotheque>
     */
    public function getLivreBibliotheques(): Collection
    {
        return $this->livreBibliotheques;
    }

    public function addLivreBibliotheque(LivreBibliotheque $livreBibliotheque): static
    {
        if (!$this->livreBibliotheques->contains($livreBibliotheque)) {
            $this->livreBibliotheques->add($livreBibliotheque);
            $livreBibliotheque->setBibliotheque($this);
        }

        return $this;
    }

    public function removeLivreBibliotheque(LivreBibliotheque $livreBibliotheque): static
    {
        if ($this->livreBibliotheques->removeElement($livreBibliotheque)) {
            // set the owning side to null (unless already changed)
            if ($livreBibliotheque->getBibliotheque() === $this) {
                $livreBibliotheque->setBibliotheque(null);
            }
        }

        return $this;
    }

    public function isModifiable(): ?bool
    {
        return $this->modifiable;
    }

    public function setModifiable(bool $modifiable): static
    {
        $this->modifiable = $modifiable;

        return $this;
    }
}
