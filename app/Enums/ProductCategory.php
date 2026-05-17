<?php

namespace App\Enums;

enum ProductCategory: string
{
    case Couscous    = 'Couscous';
    case Semoule     = 'Semoule';
    case Farine      = 'Farine';
    case CheveuxDAnge = "Cheveux d'Ange";
    case PatesVrac   = 'Pâtes vrac';
    case PatesPtc    = 'Pâtes ptc';
    case Amane       = 'Amane';

    /** Returns all category values as a plain array — the single source of truth. */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
