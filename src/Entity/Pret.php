<?php

namespace App\Entity;

use App\Enum\StatutPret;
use App\Repository\PretRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDemande = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateEcheance = null;

    #[ORM\Column(enumType: StatutPret::class)]
    private StatutPret $statut = StatutPret::EN_ATTENTE;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $emprunteur = null;

    #[ORM\ManyToOne(inversedBy: 'pretsTraites')]
    private ?User $traitePar = null;

    public function __construct()
    {
        $this->dateDemande = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeImmutable
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeImmutable $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getDateEcheance(): ?\DateTimeImmutable
    {
        return $this->dateEcheance;
    }

    public function setDateEcheance(?\DateTimeImmutable $dateEcheance): static
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    public function getStatut(): StatutPret
    {
        return $this->statut;
    }

    public function setStatut(StatutPret $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getEmprunteur(): ?User
    {
        return $this->emprunteur;
    }

    public function setEmprunteur(?User $emprunteur): static
    {
        $this->emprunteur = $emprunteur;

        return $this;
    }

    public function getTraitePar(): ?User
    {
        return $this->traitePar;
    }

    public function setTraitePar(?User $traitePar): static
    {
        $this->traitePar = $traitePar;

        return $this;
    }
}