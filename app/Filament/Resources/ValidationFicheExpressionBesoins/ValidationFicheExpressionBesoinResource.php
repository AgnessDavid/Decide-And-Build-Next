<?php

namespace App\Filament\Resources\ValidationFicheExpressionBesoins;

use App\Filament\Resources\ValidationFicheExpressionBesoins\Pages\CreateValidationFicheExpressionBesoin;
use App\Filament\Resources\ValidationFicheExpressionBesoins\Pages\EditValidationFicheExpressionBesoin;
use App\Filament\Resources\ValidationFicheExpressionBesoins\Pages\ListValidationFicheExpressionBesoins;
use App\Filament\Resources\ValidationFicheExpressionBesoins\Pages\ViewValidationFicheExpressionBesoin;
use App\Filament\Resources\ValidationFicheExpressionBesoins\Schemas\ValidationFicheExpressionBesoinForm;
use App\Filament\Resources\ValidationFicheExpressionBesoins\Schemas\ValidationFicheExpressionBesoinInfolist;
use App\Filament\Resources\ValidationFicheExpressionBesoins\Tables\ValidationFicheExpressionBesoinsTable;
use App\Models\ValidationFicheExpressionBesoin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ValidationFicheExpressionBesoinResource extends Resource
{
    protected static ?string $model = ValidationFicheExpressionBesoin::class;

    protected static ?string $navigationLabel = 'Validation fiche de besoin ';
    protected static UnitEnum|string|null $navigationGroup = 'Gestion autorisation et validation';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShieldCheck;
    protected static ?string $recordTitleAttribute = 'Gestion Validation';


    public static function canViewAny(): bool
    {
        return auth()->check() && (
             auth()->user()->hasRole('admin')
        );
    }


    public static function form(Schema $schema): Schema
    {
        return ValidationFicheExpressionBesoinForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ValidationFicheExpressionBesoinInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ValidationFicheExpressionBesoinsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListValidationFicheExpressionBesoins::route('/'),
            'create' => CreateValidationFicheExpressionBesoin::route('/create'),
            'view' => ViewValidationFicheExpressionBesoin::route('/{record}'),
            'edit' => EditValidationFicheExpressionBesoin::route('/{record}/edit'),
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
