<?php

namespace App\Filament\Resources\FicheExpressionBesoins;

use App\Filament\Resources\FicheExpressionBesoins\Pages\CreateFicheExpressionBesoin;
use App\Filament\Resources\FicheExpressionBesoins\Pages\EditFicheExpressionBesoin;
use App\Filament\Resources\FicheExpressionBesoins\Pages\ListFicheExpressionBesoins;
use App\Filament\Resources\FicheExpressionBesoins\Pages\ViewFicheExpressionBesoin;
use App\Filament\Resources\FicheExpressionBesoins\Schemas\FicheExpressionBesoinForm;
use App\Filament\Resources\FicheExpressionBesoins\Schemas\FicheExpressionBesoinInfolist;
use App\Filament\Resources\FicheExpressionBesoins\Tables\FicheExpressionBesoinsTable;
use UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FicheExpressionBesoinResource extends Resource
{
  protected static ?string $model = \App\Models\FicheBesoin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    protected static UnitEnum|string|null $navigationGroup = '  Gestion Production et Imprimerie';
protected static ?string $navigationLabel = 'Fiche de besoin client';


    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }


    public static function form(Schema $schema): Schema
    {
        return FicheExpressionBesoinForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FicheExpressionBesoinInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FicheExpressionBesoinsTable::configure($table);
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
            'index' => ListFicheExpressionBesoins::route('/'),
            'create' => CreateFicheExpressionBesoin::route('/create'),
            'view' => ViewFicheExpressionBesoin::route('/{record}'),
            'edit' => EditFicheExpressionBesoin::route('/{record}/edit'),
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
