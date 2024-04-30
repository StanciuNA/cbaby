<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
#[HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Joueur implements  UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_maj = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, CompositionEquipe>
     */
    #[ORM\OneToMany(targetEntity: CompositionEquipe::class, mappedBy: 'joueur')]
    private Collection $composition;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'expediteur')]
    private Collection $notifs_envoyes;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'destinataire')]
    private Collection $notifs_recues;

    public function __construct()
    {
        $this->composition = new ArrayCollection();
        $this->notifs_envoyes = new ArrayCollection();
        $this->notifs_recues = new ArrayCollection();
    }

    #[PrePersist]
    public function setCreatedAtOnCreate(PrePersistEventArgs $eventArgs): void
    {
        $now = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
        $this->date_creation = $now;
        $this->date_creation = $now;
    }

    #[PreUpdate]
    public function setTimestampsOnUpdate(): void
    {
        $this->date_creation = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
    }

    public function __toString()
    {
        return $this->getPseudo();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeImmutable $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateMaj(): ?\DateTimeInterface
    {
        return $this->date_maj;
    }

    public function setDateMaj(?\DateTimeInterface $date_maj): static
    {
        $this->date_maj = $date_maj;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, CompositionEquipe>
     */
    public function getComposition(): Collection
    {
        return $this->composition;
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               

    public function addComposition(CompositionEquipe $composition): static
    {
        if (!$this->composition->contains($composition)) {
            $this->composition->add($composition);
            $composition->setJoueur($this);
        }

        return $this;
    }

    public function removeComposition(CompositionEquipe $composition): static
    {
        if ($this->composition->removeElement($composition)) {
            // set the owning side to null (unless already changed)
            if ($composition->getJoueur() === $this) {
                $composition->setJoueur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifsEnvoyes(): Collection
    {
        return $this->notifs_envoyes;
    }

    public function addNotifsEnvoye(Notification $notifsEnvoye): static
    {
        if (!$this->notifs_envoyes->contains($notifsEnvoye)) {
            $this->notifs_envoyes->add($notifsEnvoye);
            $notifsEnvoye->setExpediteur($this);
        }

        return $this;
    }

    public function removeNotifsEnvoye(Notification $notifsEnvoye): static
    {
        if ($this->notifs_envoyes->removeElement($notifsEnvoye)) {
            // set the owning side to null (unless already changed)
            if ($notifsEnvoye->getExpediteur() === $this) {
                $notifsEnvoye->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifsRecues(): Collection
    {
        return $this->notifs_recues;
    }

    public function addNotifsRecue(Notification $notifsRecue): static
    {
        if (!$this->notifs_recues->contains($notifsRecue)) {
            $this->notifs_recues->add($notifsRecue);
            $notifsRecue->setDestinataire($this);
        }

        return $this;
    }

    public function removeNotifsRecue(Notification $notifsRecue): static
    {
        if ($this->notifs_recues->removeElement($notifsRecue)) {
            // set the owning side to null (unless already changed)
            if ($notifsRecue->getDestinataire() === $this) {
                $notifsRecue->setDestinataire(null);
            }
        }

        return $this;
    }

}
