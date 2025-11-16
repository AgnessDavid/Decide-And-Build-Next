<?php

namespace App\Filament\Resources\Validations\Pages;

use App\Filament\Resources\Validations\ValidationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateValidation extends CreateRecord
{
    protected static string $resource = ValidationResource::class;
}
