<?php

namespace App\Filament\Resources\SessionCaisses;

use App\Filament\Resources\SessionCaisses\Pages\CreateSessionCaisse;
use App\Filament\Resources\SessionCaisses\Pages\EditSessionCaisse;
use App\Filament\Resources\SessionCaisses\Pages\ListSessionCaisses;
use App\Filament\Resources\SessionCaisses\Pages\ViewSessionCaisse;
use App\Filament\Resources\SessionCaisses\Schemas\SessionCaisseForm;
use App\Filament\Resources\SessionCaisses\Schemas\SessionCaisseInfolist;
use App\Filament\Resources\SessionCaisses\Tables\SessionCaissesTable;
use App\Models\SessionCaisse;
use  UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SessionCaisseResource extends Resource
{
    protected static ?string $model = SessionCaisse::class;
    protected static UnitEnum|string|null $navigationGroup = 'Gestion Caisse';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowDownTray;

    protected static ?string $recordTitleAttribute = 'SessionCaisse';

    public static function canViewAny(): bool
    {
        return auth()->check() && (
             auth()->user()->hasRole('admin')
        );
    }


    public static function form(Schema $schema): Schema
    {
        return SessionCaisseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SessionCaisseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessionCaissesTable::configure($table);
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
            'index' => ListSessionCaisses::route('/'),
            'create' => CreateSessionCaisse::route('/create'),
            'view' => ViewSessionCaisse::route('/{record}'),
            'edit' => EditSessionCaisse::route('/{record}/edit'),
        ];
    }

public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}




}
