<?php

namespace App\Entity;

use App\Enum\Fonction;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['membre' => Membre::class, 'admin' => Admin::class])]
abstract class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 100)]
    protected ?string $nomComplet = null;

    #[ORM\Column(length: 20)]
    protected ?string $tel = null;

    #[ORM\Column(length: 100)]
    protected ?string $adresse = null;

    #[ORM\Column(length: 100, unique: true)]
    protected ?string $login = null;

    #[ORM\Column(length: 255)]
    protected ?string $password = null;

    #[ORM\Column(enumType: Fonction::class, nullable: true)]
    protected ?Fonction $fonction = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    protected ?Groupement $groupement = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'utilisateur')]
    private Collection $participations;

    /**
     * @var Collection<int, Versement>
     */
    #[ORM\OneToMany(targetEntity: Versement::class, mappedBy: 'utilisateur')]
    private Collection $versements;

    /**
     * @var Collection<int, Pret>
     */
    #[ORM\OneToMany(targetEntity: Pret::class, mappedBy: 'emprunteur')]
    private Collection $prets;

    /**
     * @var Collection<int, Pret>
     */
    #[ORM\OneToMany(targetEntity: Pret::class, mappedBy: 'traitePar')]
    private Collection $pretsTraites;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
        $this->versements = new ArrayCollection();
        $this->prets = new ArrayCollection();
        $this->pretsTraites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): static
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

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

    public function getFonction(): ?Fonction
    {
        return $this->fonction;
    }

    public function setFonction(?Fonction $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setGroupement(?Groupement $groupement): static
    {
        $this->groupement = $groupement;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getUtilisateur() === $this) {
                $participation->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Versement>
     */
    public function getVersements(): Collection
    {
        return $this->versements;
    }

    public function addVersement(Versement $versement): static
    {
        if (!$this->versements->contains($versement)) {
            $this->versements->add($versement);
            $versement->setUtilisateur($this);
        }

        return $this;
    }

    public function removeVersement(Versement $versement): static
    {
        if ($this->versements->removeElement($versement)) {
            // set the owning side to null (unless already changed)
            if ($versement->getUtilisateur() === $this) {
                $versement->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pret>
     */
    public function getPrets(): Collection
    {
        return $this->prets;
    }

    public function addPret(Pret $pret): static
    {
        if (!$this->prets->contains($pret)) {
            $this->prets->add($pret);
            $pret->setEmprunteur($this);
        }

        return $this;
    }

    public function removePret(Pret $pret): static
    {
        if ($this->prets->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getEmprunteur() === $this) {
                $pret->setEmprunteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pret>
     */
    public function getPretsTraites(): Collection
    {
        return $this->pretsTraites;
    }

    public function addPretsTraite(Pret $pretsTraite): static
    {
        if (!$this->pretsTraites->contains($pretsTraite)) {
            $this->pretsTraites->add($pretsTraite);
            $pretsTraite->setTraitePar($this);
        }

        return $this;
    }

    public function removePretsTraite(Pret $pretsTraite): static
    {
        if ($this->pretsTraites->removeElement($pretsTraite)) {
            // set the owning side to null (unless already changed)
            if ($pretsTraite->getTraitePar() === $this) {
                $pretsTraite->setTraitePar(null);
            }
        }

        return $this;
    }
}