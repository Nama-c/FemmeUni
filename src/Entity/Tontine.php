<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Tontine extends Campagne
{
    #[ORM\Column(nullable: true)]
    private ?int $periode = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbTour = null;

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(?int $periode): static
    {
        $this->periode = $periode;

        return $this;
    }

    public function getNbTour(): ?int
    {
        return $this->nbTour;
    }

    public function setNbTour(?int $nbTour): static
    {
        $this->nbTour = $nbTour;

        return $this;
    }
}