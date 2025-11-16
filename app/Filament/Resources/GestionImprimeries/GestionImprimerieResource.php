<?php

namespace App\Filament\Resources\GestionImprimeries;

use App\Filament\Resources\GestionImprimeries\Pages\CreateGestionImprimerie;
use App\Filament\Resources\GestionImprimeries\Pages\EditGestionImprimerie;
use App\Filament\Resources\GestionImprimeries\Pages\ListGestionImprimeries;
use App\Filament\Resources\GestionImprimeries\Pages\ViewGestionImprimerie;
use App\Filament\Resources\GestionImprimeries\Schemas\GestionImprimerieForm;
use App\Filament\Resources\GestionImprimeries\Schemas\GestionImprimerieInfolist;
use App\Filament\Resources\GestionImprimeries\Tables\GestionImprimeriesTable;
use App\Models\GestionImprimerie;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class GestionImprimerieResource extends Resource
{
    protected static ?string $model = GestionImprimerie::class;

    protected static ?string $navigationLabel = ' Gestion fiche de besoin';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartPie;

    protected static ?string $recordTitleAttribute = 'Gestion Imprimerie';

    protected static UnitEnum|string|null $navigationGroup = 'Gestion Produits et Stock';

    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }


    public static function form(Schema $schema): Schema
    {
        return GestionImprimerieForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GestionImprimerieInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GestionImprimeriesTable::configure($table);
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
            'index' => ListGestionImprimeries::route('/'),
            'create' => CreateGestionImprimerie::route('/create'),
            'view' => ViewGestionImprimerie::route('/{record}'),
            'edit' => EditGestionImprimerie::route('/{record}/edit'),
        ];
    }


    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}


}
