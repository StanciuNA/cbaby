<?php

namespace App\Entity;

use App\Repository\CompositionEquipeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompositionEquipeRepository::class)]
class CompositionEquipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'compositionEquipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $equipe = null;

    #[ORM\Column]
    private ?bool $hote = null;

    #[ORM\ManyToOne(inversedBy: 'composition')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Joueur $joueur = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function isHote(): ?bool
    {
        return $this->hote;
    }

    public function setHote(bool $hote): static
    {
        $this->hote = $hote;

        return $this;
    }

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): static
    {
        $this->joueur = $joueur;

        return $this;
    }
}
