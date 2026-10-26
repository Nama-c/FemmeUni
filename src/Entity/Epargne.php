<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Epargne extends Campagne
{
    #[ORM\Column(nullable: true)]
    private ?int $solde = 0;

    #[ORM\Column(nullable: true)]
    private ?int $objectif = null;

    #[ORM\Column(nullable: true)]
    private ?bool $libre = false;

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(?int $solde): static
    {
        $this->solde = $solde;

        return $this;
    }

    public function getObjectif(): ?int
    {
        return $this->objectif;
    }

    public function setObjectif(?int $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function isLibre(): ?bool
    {
        return $this->libre;
    }

    public function setLibre(?bool $libre): static
    {
        $this->libre = $libre;

        return $this;
    }
}