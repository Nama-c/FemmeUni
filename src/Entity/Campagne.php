<?php

namespace App\Entity;

use App\Repository\CampagneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
class Campagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateDbAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateFiinAt = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $creatAtAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAtAt = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

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

    public function getDateDbAt(): ?\DateTimeImmutable
    {
        return $this->dateDbAt;
    }

    public function setDateDbAt(\DateTimeImmutable $dateDbAt): static
    {
        $this->dateDbAt = $dateDbAt;

        return $this;
    }

    public function getDateFiinAt(): ?\DateTimeImmutable
    {
        return $this->dateFiinAt;
    }

    public function setDateFiinAt(\DateTimeImmutable $dateFiinAt): static
    {
        $this->dateFiinAt = $dateFiinAt;

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

    public function getCreatAtAt(): ?\DateTimeImmutable
    {
        return $this->creatAtAt;
    }

    public function setCreatAtAt(\DateTimeImmutable $creatAtAt): static
    {
        $this->creatAtAt = $creatAtAt;

        return $this;
    }

    public function getUpdateAtAt(): ?\DateTimeImmutable
    {
        return $this->updateAtAt;
    }

    public function setUpdateAtAt(?\DateTimeImmutable $updateAtAt): static
    {
        $this->updateAtAt = $updateAtAt;

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
}
