<?php

namespace App\Filament\Resources\ImprimerieExpressionBesoins\Pages;

use App\Filament\Resources\ImprimerieExpressionBesoins\ImprimerieExpressionBesoinResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditImprimerieExpressionBesoin extends EditRecord
{
    protected static string $resource = ImprimerieExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
