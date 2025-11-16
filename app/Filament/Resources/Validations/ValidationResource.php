<?php

namespace App\Filament\Resources\Validations;

use App\Filament\Resources\Validations\Pages\CreateValidation;
use App\Filament\Resources\Validations\Pages\EditValidation;
use App\Filament\Resources\Validations\Pages\ListValidations;
use App\Filament\Resources\Validations\Pages\ViewValidation;
use App\Filament\Resources\Validations\Schemas\ValidationForm;
use App\Filament\Resources\Validations\Schemas\ValidationInfolist;
use App\Filament\Resources\Validations\Tables\ValidationsTable;
use App\Models\Validation;
use BackedEnum;
 use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ValidationResource extends Resource
{
    protected static ?string $model = Validation::class;

    protected static ?string $navigationLabel = 'Autorisation de production';
    protected static UnitEnum|string|null $navigationGroup = 'Gestion autorisation et validation';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckCircle;
    protected static ?string $recordTitleAttribute = 'Gestion Validation';

    public static function canViewAny(): bool
    {
        return auth()->check() && (
             auth()->user()->hasRole('admin')
        );
    }


    public static function form(Schema $schema): Schema
    {
        return ValidationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ValidationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {

      
        return ValidationsTable::configure($table);
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
            'index' => ListValidations::route('/'),
            'create' => CreateValidation::route('/create'),
            'view' => ViewValidation::route('/{record}'),
            'edit' => EditValidation::route('/{record}/edit'),
        ];
    }


    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}



}
