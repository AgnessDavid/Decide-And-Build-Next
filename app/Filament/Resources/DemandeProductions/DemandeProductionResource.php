<?php

namespace App\Filament\Resources\DemandeProductions;

use App\Filament\Resources\DemandeProductions\Pages\CreateDemandeProduction;
use App\Filament\Resources\DemandeProductions\Pages\EditDemandeProduction;
use App\Filament\Resources\DemandeProductions\Pages\ListDemandeProductions;
use App\Filament\Resources\DemandeProductions\Pages\ViewDemandeProduction;
use App\Filament\Resources\DemandeProductions\Schemas\DemandeProductionForm;
use App\Filament\Resources\DemandeProductions\Schemas\DemandeProductionInfolist;
use App\Filament\Resources\DemandeProductions\Tables\DemandeProductionsTable;
use App\Models\DemandeProduction;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Models\DemandeImpression;
class DemandeProductionResource extends Resource
{
protected static ?string $model = DemandeImpression::class;

   protected static string|BackedEnum|null $navigationIcon = Heroicon::Clipboard; // icône de clipboard

    protected static ?string $navigationLabel = ' Demande de production';
    protected static UnitEnum|string|null $navigationGroup = '  Gestion Production et Imprimerie';


    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }



    protected static ?string $recordTitleAttribute = 'Demande Production';

    public static function form(Schema $schema): Schema
    {
        return DemandeProductionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DemandeProductionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DemandeProductionsTable::configure($table);
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
            'index' => ListDemandeProductions::route('/'),
            'create' => CreateDemandeProduction::route('/create'),
            'view' => ViewDemandeProduction::route('/{record}'),
            'edit' => EditDemandeProduction::route('/{record}/edit'),
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
