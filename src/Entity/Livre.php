<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cycle = null;

    #[ORM\Column(nullable: true)]
    private ?int $tome = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resume = null;

    #[ORM\ManyToMany(targetEntity: Auteur::class, mappedBy: 'livre')]
    private Collection $auteurs;

    #[ORM\ManyToMany(targetEntity: Genre::class, mappedBy: 'livre')]
    private Collection $genres;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Langue $langue = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Edition $edition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couverture = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: LivreUser::class)]
    private Collection $livreUsers;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->livreUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCycle(): ?string
    {
        return $this->cycle;
    }

    public function setCycle(?string $cycle): static
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getTome(): ?int
    {
        return $this->tome;
    }

    public function setTome(?int $tome): static
    {
        $this->tome = $tome;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
            $auteur->addLivre($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        if ($this->auteurs->removeElement($auteur)) {
            $auteur->removeLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addLivre($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Langue>
     */
    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): static
    {
        $this->langue = $langue;

        return $this;
    }

    public function getEdition(): ?Edition
    {
        return $this->edition;
    }

    public function setEdition(?Edition $edition): static
    {
        $this->edition = $edition;

        return $this;
    }


    public function getnomComplet(){
        return $this->cycle.' '.$this->tome.' '.$this->titre;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture(?string $couverture): static
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getTitreComplet(){
        return $this->cycle.' '.$this->tome.' '.$this->titre;
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
            $livreUser->setLivre($this);
        }

        return $this;
    }

    public function removeLivreUser(LivreUser $livreUser): static
    {
        if ($this->livreUsers->removeElement($livreUser)) {
            // set the owning side to null (unless already changed)
            if ($livreUser->getLivre() === $this) {
                $livreUser->setLivre(null);
            }
        }

        return $this;
    }
}
