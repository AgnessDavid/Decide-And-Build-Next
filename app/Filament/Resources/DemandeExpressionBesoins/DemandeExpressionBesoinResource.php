<?php

namespace App\Filament\Resources\DemandeExpressionBesoins;

use App\Filament\Resources\DemandeExpressionBesoins\Pages\CreateDemandeExpressionBesoin;
use App\Filament\Resources\DemandeExpressionBesoins\Pages\EditDemandeExpressionBesoin;
use App\Filament\Resources\DemandeExpressionBesoins\Pages\ListDemandeExpressionBesoins;
use App\Filament\Resources\DemandeExpressionBesoins\Pages\ViewDemandeExpressionBesoin;
use App\Filament\Resources\DemandeExpressionBesoins\Schemas\DemandeExpressionBesoinForm;
use App\Filament\Resources\DemandeExpressionBesoins\Schemas\DemandeExpressionBesoinInfolist;
use App\Filament\Resources\DemandeExpressionBesoins\Tables\DemandeExpressionBesoinsTable;
use App\Models\DemandeExpressionBesoin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DemandeExpressionBesoinResource extends Resource
{
    protected static ?string $model = DemandeExpressionBesoin::class;


    protected static ?string $navigationLabel = 'Demande fiche de besoin';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clipboard; // icône de clipboard

    protected static UnitEnum|string|null $navigationGroup = '  Gestion Production et Imprimerie';
  
    protected static ?string $recordTitleAttribute = 'Demande Production';


    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }


    public static function form(Schema $schema): Schema
    {
        return DemandeExpressionBesoinForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DemandeExpressionBesoinInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DemandeExpressionBesoinsTable::configure($table);
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
            'index' => ListDemandeExpressionBesoins::route('/'),
            'create' => CreateDemandeExpressionBesoin::route('/create'),
            'view' => ViewDemandeExpressionBesoin::route('/{record}'),
            'edit' => EditDemandeExpressionBesoin::route('/{record}/edit'),
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}




}
