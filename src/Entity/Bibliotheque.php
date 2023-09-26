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

    #[ORM\Column]
    private ?bool $modifiable = true;

    #[ORM\OneToMany(mappedBy: 'bibliotheque', targetEntity: LivreUser::class)]
    private Collection $livreUsers;

    public function __construct()
    {
        $this->livreUsers = new ArrayCollection();
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

    public function isModifiable(): ?bool
    {
        return $this->modifiable;
    }

    public function setModifiable(bool $modifiable): static
    {
        $this->modifiable = $modifiable;

        return $this;
    }

    /**
     * @return Collection<int, LivreUser>
     */
    public function getLivreUsers(): Collection
    {
        return $this->livreUsers;
    }

    public function addLivreUser(LivreUser $livreUser): static
    {
        if (!$this->livreUsers->contains($livreUser)) {
            $this->livreUsers->add($livreUser);
            $livreUser->setBibliotheque($this);
        }

        return $this;
    }

    public function removeLivreUser(LivreUser $livreUser): static
    {
        if ($this->livreUsers->removeElement($livreUser)) {
            // set the owning side to null (unless already changed)
            if ($livreUser->getBibliotheque() === $this) {
                $livreUser->setBibliotheque(null);
            }
        }

        return $this;
    }
}
