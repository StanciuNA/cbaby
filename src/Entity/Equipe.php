<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    /**
     * @var Collection<int, CompositionEquipe>
     */
    #[ORM\OneToMany(targetEntity: CompositionEquipe::class, mappedBy: 'equipe')]
    private Collection $compositionEquipes;

    /**
     * @var Collection<int, Jeu>
     */
    #[ORM\OneToMany(targetEntity: Jeu::class, mappedBy: 'idEquipeUn')]
    private Collection $jeux;

    /**
     * @var Collection<int, Jeu>
     */
    #[ORM\OneToMany(targetEntity: Jeu::class, mappedBy: 'idEqipeDeux')]
    private Collection $jeuxEq2;

    /**
     * @var Collection<int, Jeu>
     */
    #[ORM\OneToMany(targetEntity: Jeu::class, mappedBy: 'vainqueur')]
    private Collection $jeux_gagnes;

    public function __construct()
    {
        $this->compositionEquipes = new ArrayCollection();
        $this->jeux = new ArrayCollection();
        $this->jeuxEq2 = new ArrayCollection();
        $this->jeux_gagnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, CompositionEquipe>
     */
    public function getCompositionEquipes(): Collection
    {
        return $this->compositionEquipes;
    }

    public function addCompositionEquipe(CompositionEquipe $compositionEquipe): static
    {
        if (!$this->compositionEquipes->contains($compositionEquipe)) {
            $this->compositionEquipes->add($compositionEquipe);
            $compositionEquipe->setEquipe($this);
        }

        return $this;
    }

    public function removeCompositionEquipe(CompositionEquipe $compositionEquipe): static
    {
        if ($this->compositionEquipes->removeElement($compositionEquipe)) {
            // set the owning side to null (unless already changed)
            if ($compositionEquipe->getEquipe() === $this) {
                $compositionEquipe->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Jeu>
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeux(Jeu $jeux): static
    {
        if (!$this->jeux->contains($jeux)) {
            $this->jeux->add($jeux);
            $jeux->setIdEquipeUn($this);
        }

        return $this;
    }

    public function removeJeux(Jeu $jeux): static
    {
        if ($this->jeux->removeElement($jeux)) {
            // set the owning side to null (unless already changed)
            if ($jeux->getIdEquipeUn() === $this) {
                $jeux->setIdEquipeUn(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Jeu>
     */
    public function getJeuxEq2(): Collection
    {
        return $this->jeuxEq2;
    }

    public function addJeuxEq2(Jeu $jeuxEq2): static
    {
        if (!$this->jeuxEq2->contains($jeuxEq2)) {
            $this->jeuxEq2->add($jeuxEq2);
            $jeuxEq2->setIdEqipeDeux($this);
        }

        return $this;
    }

    public function removeJeuxEq2(Jeu $jeuxEq2): static
    {
        if ($this->jeuxEq2->removeElement($jeuxEq2)) {
            // set the owning side to null (unless already changed)
            if ($jeuxEq2->getIdEqipeDeux() === $this) {
                $jeuxEq2->setIdEqipeDeux(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Jeu>
     */
    public function getJeuxGagnes(): Collection
    {
        return $this->jeux_gagnes;
    }

    public function addJeuxGagne(Jeu $jeuxGagne): static
    {
        if (!$this->jeux_gagnes->contains($jeuxGagne)) {
            $this->jeux_gagnes->add($jeuxGagne);
            $jeuxGagne->setVainqueur($this);
        }

        return $this;
    }

    public function removeJeuxGagne(Jeu $jeuxGagne): static
    {
        if ($this->jeux_gagnes->removeElement($jeuxGagne)) {
            // set the owning side to null (unless already changed)
            if ($jeuxGagne->getVainqueur() === $this) {
                $jeuxGagne->setVainqueur(null);
            }
        }

        return $this;
    }
}
