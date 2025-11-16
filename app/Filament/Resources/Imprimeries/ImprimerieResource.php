<?php

namespace App\Filament\Resources\Imprimeries;

use App\Filament\Resources\Imprimeries\Pages\CreateImprimerie;
use App\Filament\Resources\Imprimeries\Pages\EditImprimerie;
use App\Filament\Resources\Imprimeries\Pages\ListImprimeries;
use App\Filament\Resources\Imprimeries\Pages\ViewImprimerie;
use App\Filament\Resources\Imprimeries\Schemas\ImprimerieForm;
use App\Filament\Resources\Imprimeries\Schemas\ImprimerieInfolist;
use App\Filament\Resources\Imprimeries\Tables\ImprimeriesTable;
use App\Models\Imprimerie;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ImprimerieResource extends Resource
{
    protected static ?string $model = Imprimerie::class;

protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentPlus; // icône pour créer un document


    protected static ?string $navigationLabel = 'Imprimerie de production';

     protected static UnitEnum|string|null $navigationGroup = '  Gestion Production et Imprimerie';
  
    protected static ?string $recordTitleAttribute = 'Imprimerie';



    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }




    public static function form(Schema $schema): Schema
    {
        return ImprimerieForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImprimerieInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImprimeriesTable::configure($table);
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
            'index' => ListImprimeries::route('/'),
            'create' => CreateImprimerie::route('/create'),
            'view' => ViewImprimerie::route('/{record}'),
            'edit' => EditImprimerie::route('/{record}/edit'),
        ];
    }

public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}




}
