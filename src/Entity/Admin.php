<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Admin extends User
{
    public function getRoles(): array
    {
        return ['ROLE_ADMIN', 'ROLE_USER'];
    }
}