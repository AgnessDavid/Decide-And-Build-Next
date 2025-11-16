<?php

namespace App\Filament\Resources\PaiementOnlines;

use App\Filament\Resources\PaiementOnlines\Pages\CreatePaiementOnline;
use App\Filament\Resources\PaiementOnlines\Pages\EditPaiementOnline;
use App\Filament\Resources\PaiementOnlines\Pages\ListPaiementOnlines;
use App\Filament\Resources\PaiementOnlines\Pages\ViewPaiementOnline;
use App\Filament\Resources\PaiementOnlines\Schemas\PaiementOnlineForm;
use App\Filament\Resources\PaiementOnlines\Schemas\PaiementOnlineInfolist;
use App\Filament\Resources\PaiementOnlines\Tables\PaiementOnlinesTable;
use App\Models\PaiementOnline;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PaiementOnlineResource extends Resource
{
    protected static ?string $model = PaiementOnline::class;


    protected static UnitEnum|string|null $navigationGroup = 'Gestion Caisse en ligne';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;

    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }


    public static function form(Schema $schema): Schema
    {
        return PaiementOnlineForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PaiementOnlineInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaiementOnlinesTable::configure($table);
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
            'index' => ListPaiementOnlines::route('/'),
            'create' => CreatePaiementOnline::route('/create'),
            'view' => ViewPaiementOnline::route('/{record}'),
            'edit' => EditPaiementOnline::route('/{record}/edit'),
        ];
    }

    /**
     * Affiche un badge de notification dans la barre de navigation latérale
     * qui montre le nombre total d'enregistrements de paiements en ligne.
     * 
     * Cette méthode est utilisée pour:
     * - La page index (ListPaiementOnlines): Affiche le nombre total de paiements
     * - La page create (CreatePaiementOnline): Met à jour le compteur après création
     * - La page edit (EditPaiementOnline): Reflète les modifications
     * - La page view (ViewPaiementOnline): Montre le compteur actuel
     *
     * @return string|null Le nombre total de paiements en ligne
     */
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
