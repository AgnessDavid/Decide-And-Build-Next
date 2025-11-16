<?php

namespace App\Filament\Resources\Depenses;

use App\Filament\Resources\Depenses\Pages\CreateDepense;
use App\Filament\Resources\Depenses\Pages\EditDepense;
use App\Filament\Resources\Depenses\Pages\ListDepenses;
use App\Filament\Resources\Depenses\Pages\ViewDepense;
use App\Filament\Resources\Depenses\Schemas\DepenseForm;
use App\Filament\Resources\Depenses\Schemas\DepenseInfolist;
use App\Filament\Resources\Depenses\Tables\DepensesTable;
use App\Models\Depense;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DepenseResource extends Resource
{
    protected static ?string $model = Depense::class;
    protected static UnitEnum|string|null $navigationGroup = 'Gestion Caisse';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar; // icône dollar


    protected static ?string $recordTitleAttribute = 'Depense';


    /**
     *    Attribute qui détermine si l'utilisateur peut voir la ressource Depense
     * 
     */
    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }

    public static function form(Schema $schema): Schema
    {
        return DepenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DepenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DepensesTable::configure($table);
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
            'index' => ListDepenses::route('/'),
            'create' => CreateDepense::route('/create'),
            'view' => ViewDepense::route('/{record}'),
            'edit' => EditDepense::route('/{record}/edit'),
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
