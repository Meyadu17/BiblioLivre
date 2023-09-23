<?php

namespace App\Entity;

use App\Repository\LivreBibliothequeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreBibliothequeRepository::class)]
class LivreBibliotheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'livreBibliotheques')]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'livreBibliotheques')]
    private ?Bibliotheque $bibliotheque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): static
    {
        $this->livre = $livre;

        return $this;
    }

    public function getBibliotheque(): ?Bibliotheque
    {
        return $this->bibliotheque;
    }

    public function setBibliotheque(?Bibliotheque $bibliotheque): static
    {
        $this->bibliotheque = $bibliotheque;

        return $this;
    }

}
