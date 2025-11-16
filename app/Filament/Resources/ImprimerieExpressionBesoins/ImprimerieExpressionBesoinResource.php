<?php

namespace App\Filament\Resources\ImprimerieExpressionBesoins;

use App\Filament\Resources\ImprimerieExpressionBesoins\Pages\CreateImprimerieExpressionBesoin;
use App\Filament\Resources\ImprimerieExpressionBesoins\Pages\EditImprimerieExpressionBesoin;
use App\Filament\Resources\ImprimerieExpressionBesoins\Pages\ListImprimerieExpressionBesoins;
use App\Filament\Resources\ImprimerieExpressionBesoins\Pages\ViewImprimerieExpressionBesoin;
use App\Filament\Resources\ImprimerieExpressionBesoins\Schemas\ImprimerieExpressionBesoinForm;
use App\Filament\Resources\ImprimerieExpressionBesoins\Schemas\ImprimerieExpressionBesoinInfolist;
use App\Filament\Resources\ImprimerieExpressionBesoins\Tables\ImprimerieExpressionBesoinsTable;
use App\Models\ImprimerieExpressionBesoin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class ImprimerieExpressionBesoinResource extends Resource
{
    protected static ?string $model = ImprimerieExpressionBesoin::class;

    protected static ?string $navigationLabel = 'Imprimerie fiche de besoin';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentPlus; // icône pour créer un document


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
        return ImprimerieExpressionBesoinForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImprimerieExpressionBesoinInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImprimerieExpressionBesoinsTable::configure($table);
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
            'index' => ListImprimerieExpressionBesoins::route('/'),
            'create' => CreateImprimerieExpressionBesoin::route('/create'),
            'view' => ViewImprimerieExpressionBesoin::route('/{record}'),
            'edit' => EditImprimerieExpressionBesoin::route('/{record}/edit'),
        ];
    }


public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
