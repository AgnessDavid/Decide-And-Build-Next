<?php

namespace App\Filament\Resources\CommandeOnlines;

use App\Filament\Resources\CommandeOnlines\Pages\CreateCommandeOnline;
use App\Filament\Resources\CommandeOnlines\Pages\EditCommandeOnline;
use App\Filament\Resources\CommandeOnlines\Pages\ListCommandeOnlines;
use App\Filament\Resources\CommandeOnlines\Pages\ViewCommandeOnline;
use App\Filament\Resources\CommandeOnlines\Schemas\CommandeOnlineForm;
use App\Filament\Resources\CommandeOnlines\Schemas\CommandeOnlineInfolist;
use App\Filament\Resources\CommandeOnlines\Tables\CommandeOnlinesTable;
use App\Models\CommandeOnline;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class CommandeOnlineResource extends Resource
{
    protected static ?string $model = CommandeOnline::class;


    protected static UnitEnum|string|null $navigationGroup = 'Gestion Caisse en ligne';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar; // icône dollar


    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }



    protected static ?string $recordTitleAttribute = 'Commande en ligne';

    public static function form(Schema $schema): Schema
    {
        return CommandeOnlineForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CommandeOnlineInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommandeOnlinesTable::configure($table);
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
            'index' => ListCommandeOnlines::route('/'),
            'create' => CreateCommandeOnline::route('/create'),
            'view' => ViewCommandeOnline::route('/{record}'),
            'edit' => EditCommandeOnline::route('/{record}/edit'),
        ];
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

}
