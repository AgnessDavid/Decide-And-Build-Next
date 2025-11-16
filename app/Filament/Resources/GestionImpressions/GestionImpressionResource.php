<?php

namespace App\Filament\Resources\GestionImpressions;

use App\Filament\Resources\GestionImpressions\Pages\CreateGestionImpression;
use App\Filament\Resources\GestionImpressions\Pages\EditGestionImpression;
use App\Filament\Resources\GestionImpressions\Pages\ListGestionImpressions;
use App\Filament\Resources\GestionImpressions\Pages\ViewGestionImpression;
use App\Filament\Resources\GestionImpressions\Schemas\GestionImpressionForm;
use App\Filament\Resources\GestionImpressions\Schemas\GestionImpressionInfolist;
use App\Filament\Resources\GestionImpressions\Tables\GestionImpressionsTable;
use App\Models\GestionImpression;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class GestionImpressionResource extends Resource
{
    protected static ?string $model = GestionImpression::class;

    protected static ?string $navigationLabel = ' Gestion production';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;
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
        return GestionImpressionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GestionImpressionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GestionImpressionsTable::configure($table);
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
            'index' => ListGestionImpressions::route('/'),
            'create' => CreateGestionImpression::route('/create'),
            'view' => ViewGestionImpression::route('/{record}'),
            'edit' => EditGestionImpression::route('/{record}/edit'),
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
