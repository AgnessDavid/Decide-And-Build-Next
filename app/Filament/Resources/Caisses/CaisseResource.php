<?php

namespace App\Filament\Resources\Caisses;

use App\Filament\Resources\Caisses\Pages\CreateCaisse;
use App\Filament\Resources\Caisses\Pages\EditCaisse;
use App\Filament\Resources\Caisses\Pages\ListCaisses;
use App\Filament\Resources\Caisses\Pages\ViewCaisse;
use App\Filament\Resources\Caisses\Schemas\CaisseForm;
use App\Filament\Resources\Caisses\Schemas\CaisseInfolist;
use App\Filament\Resources\Caisses\Tables\CaissesTable;
use App\Models\Caisse;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CaisseResource extends Resource
{
    protected static ?string $model = Caisse::class;

   // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static UnitEnum|string|null $navigationGroup = 'Gestion Caisse';
    protected static ?string $recordTitleAttribute = 'Caisse';


    /* 
    
     Connecter en tant Admin 
     
     Distinguer les vues
    
    */ 

    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }

    // 🔹 Cacher le lien dans le menu si l'utilisateur n'a pas accès
    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }


    public static function form(Schema $schema): Schema
    {
        return CaisseForm::configure($schema);
    }

    
    public static function infolist(Schema $schema): Schema
    {
        return CaisseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CaissesTable::configure($table);
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
            'index' => ListCaisses::route('/'),
            'create' => CreateCaisse::route('/create'),
            'view' => ViewCaisse::route('/{record}'),
            'edit' => EditCaisse::route('/{record}/edit'),
        ];
    }



public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}


}
