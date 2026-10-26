<?php

namespace App\Entity;

use App\Repository\VersementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersementRepository::class)]
class Versement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateVersementAt = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\ManyToOne(inversedBy: 'versements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'versements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campagne $Campagne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVersementAt(): ?\DateTimeImmutable
    {
        return $this->dateVersementAt;
    }

    public function setDateVersementAt(\DateTimeImmutable $dateVersementAt): static
    {
        $this->dateVersementAt = $dateVersementAt;

        return $this;
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

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->Campagne;
    }

    public function setCampagne(?Campagne $Campagne): static
    {
        $this->Campagne = $Campagne;

        return $this;
    }
}
