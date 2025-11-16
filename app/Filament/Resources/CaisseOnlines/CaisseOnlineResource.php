<?php

namespace App\Filament\Resources\CaisseOnlines;

use App\Filament\Resources\CaisseOnlines\Pages\CreateCaisseOnline;
use App\Filament\Resources\CaisseOnlines\Pages\EditCaisseOnline;
use App\Filament\Resources\CaisseOnlines\Pages\ListCaisseOnlines;
use App\Filament\Resources\CaisseOnlines\Pages\ViewCaisseOnline;
use App\Filament\Resources\CaisseOnlines\Schemas\CaisseOnlineForm;
use App\Filament\Resources\CaisseOnlines\Schemas\CaisseOnlineInfolist;
use App\Filament\Resources\CaisseOnlines\Tables\CaisseOnlinesTable;
use App\Models\CaisseOnline;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CaisseOnlineResource extends Resource
{
    protected static ?string $model = CaisseOnline::class;


    protected static UnitEnum|string|null $navigationGroup = 'Gestion Caisse en ligne';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;


    protected static ?string $recordTitleAttribute = 'Caisse en ligne';


    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('admin')
        );
    }




    public static function form(Schema $schema): Schema
    {
        return CaisseOnlineForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CaisseOnlineInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CaisseOnlinesTable::configure($table);
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
            'index' => ListCaisseOnlines::route('/'),
            'create' => CreateCaisseOnline::route('/create'),
            'view' => ViewCaisseOnline::route('/{record}'),
            'edit' => EditCaisseOnline::route('/{record}/edit'),
        ];
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


}
