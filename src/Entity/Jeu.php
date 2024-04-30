<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuRepository::class)]
class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Equipe $idEquipeUn = null;

    #[ORM\ManyToOne(inversedBy: 'jeuxEq2')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Equipe $idEqipeDeux = null;

    #[ORM\Column(nullable:true)]
    private ?int $scoreEquipeUn = null;

    #[ORM\Column(nullable:true)]
    private ?int $scoreEquipeDeux = null;

    #[ORM\ManyToOne(inversedBy: 'jeux_gagnes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Equipe $vainqueur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEquipeUn(): ?Equipe
    {
        return $this->idEquipeUn;
    }

    public function setIdEquipeUn(?Equipe $idEquipeUn): static
    {
        $this->idEquipeUn = $idEquipeUn;

        return $this;
    }

    public function getIdEqipeDeux(): ?Equipe
    {
        return $this->idEqipeDeux;
    }

    public function setIdEqipeDeux(?Equipe $idEqipeDeux): static
    {
        $this->idEqipeDeux = $idEqipeDeux;

        return $this;
    }

    public function getScoreEquipeUn(): ?int
    {
        return $this->scoreEquipeUn;
    }

    public function setScoreEquipeUn(int $scoreEquipeUn): static
    {
        $this->scoreEquipeUn = $scoreEquipeUn;

        return $this;
    }

    public function getScoreEquipeDeux(): ?int
    {
        return $this->scoreEquipeDeux;
    }

    public function setScoreEquipeDeux(int $scoreEquipeDeux): static
    {
        $this->scoreEquipeDeux = $scoreEquipeDeux;

        return $this;
    }

    public function getVainqueur(): ?Equipe
    {
        return $this->vainqueur;
    }

    public function setVainqueur(?Equipe $vainqueur): static
    {
        $this->vainqueur = $vainqueur;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
