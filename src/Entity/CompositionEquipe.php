<?php

namespace App\Entity;

use App\Repository\CompositionEquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompositionEquipeRepository::class)]
class CompositionEquipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Joueur>
     */
    #[ORM\OneToMany(targetEntity: Joueur::class, mappedBy: 'compositionEquipe')]
    private Collection $joueur;

    #[ORM\ManyToOne(inversedBy: 'compositionEquipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $equipe = null;

    public function __construct()
    {
        $this->joueur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getJoueur(): Collection
    {
        return $this->joueur;
    }

    public function addJoueur(Joueur $joueur): static
    {
        if (!$this->joueur->contains($joueur)) {
            $this->joueur->add($joueur);
            $joueur->setCompositionEquipe($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): static
    {
        if ($this->joueur->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getCompositionEquipe() === $this) {
                $joueur->setCompositionEquipe(null);
            }
        }

        return $this;
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
}
