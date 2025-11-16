<?php

namespace App\Filament\Resources\MouvementStocks;

use App\Filament\Resources\MouvementStocks\Pages\CreateMouvementStock;
use App\Filament\Resources\MouvementStocks\Pages\EditMouvementStock;
use App\Filament\Resources\MouvementStocks\Pages\ListMouvementStocks;
use App\Filament\Resources\MouvementStocks\Pages\ViewMouvementStock;
use App\Filament\Resources\MouvementStocks\Schemas\MouvementStockForm;
use App\Filament\Resources\MouvementStocks\Schemas\MouvementStockInfolist;
use App\Filament\Resources\MouvementStocks\Tables\MouvementStocksTable;
use App\Models\MouvementStock;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MouvementStockResource extends Resource
{
    protected static ?string $model = MouvementStock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowPath;


    protected static UnitEnum|string|null $navigationGroup = 'Gestion Produits et Stock';
    protected static ?string $recordTitleAttribute = 'Mouvement Stocks';


    public static function canViewAny(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('agent') || auth()->user()->hasRole('admin')
        );
    }



    public static function form(Schema $schema): Schema
    {
        return MouvementStockForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MouvementStockInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MouvementStocksTable::configure($table);
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
            'index' => ListMouvementStocks::route('/'),
            'create' => CreateMouvementStock::route('/create'),
            'view' => ViewMouvementStock::route('/{record}'),
            'edit' => EditMouvementStock::route('/{record}/edit'),

             
           
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
