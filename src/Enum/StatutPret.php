<?php

namespace App\Enum;

enum StatutPret: string
{
    case EN_ATTENTE = 'en_attente';
    case APPROUVE = 'approuve';
    case REJETE = 'rejete';
    case REMBOURSE = 'rembourse';
}