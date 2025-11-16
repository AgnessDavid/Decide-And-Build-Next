<?php

namespace App\Enums;

enum CategoriePaiement: string
{
    case ESPECES = 'espèces';
    case MOBILE_MONEY = 'mobile_money';
    case EN_LIGNE = 'en_ligne';
    case CRYPTO = 'crypto';
}
