<?php

namespace App\Filament\Resources\Commandes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CommandeExport;

class CommandesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('client.nom')->searchable(),
                TextColumn::make('numero_commande')->searchable(),
                TextColumn::make('date_commande')->date()->sortable(),
                TextColumn::make('montant_ht')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state, 0, ',', ' ') . ' FCFA'),
                TextColumn::make('tva')->numeric()->sortable(),


                // 🆕 Type de support (depuis les produits)
                TextColumn::make('produits_support')
                    ->label('Support')
                    ->getStateUsing(function ($record) {
                        $supports = $record->produits
                            ->pluck('type_support')
                            ->unique()
                            ->filter()
                            ->map(fn($support) => match ($support) {
                                'papier' => 'Papier',
                                'numerique' => 'Numérique',
                                default => $support,
                            });

                        return $supports->isEmpty() ? '—' : $supports->implode(', ');
                    })
                    ->badge()
                    ->color(function ($record) {
                        $supports = $record->produits->pluck('type_support')->unique()->filter();
                        if ($supports->isEmpty())
                            return 'gray';
                        if ($supports->contains('papier'))
                            return 'primary';
                        if ($supports->contains('numerique'))
                            return 'success';
                        return 'gray';
                    })
                    ->icon(function ($record) {
                        $supports = $record->produits->pluck('type_support')->unique()->filter();
                        if ($supports->isEmpty())
                            return 'heroicon-o-question-mark-circle';
                        if ($supports->count() > 1)
                            return 'heroicon-o-squares-plus';
                        if ($supports->contains('papier'))
                            return 'heroicon-o-document-text';
                        if ($supports->contains('numerique'))
                            return 'heroicon-o-computer-desktop';
                        return 'heroicon-o-question-mark-circle';
                    })
                    ->toggleable(),

                // 🆕 Format (depuis les produits)
                TextColumn::make('produits_formats')
                    ->label('Format')
                    ->getStateUsing(function ($record) {
                        $formats = $record->produits
                            ->pluck('format')
                            ->unique()
                            ->filter();

                        return $formats->isEmpty() ? '—' : $formats->implode(', ');
                    })
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-rectangle-stack')
                    ->toggleable()
                    ->wrap(),
              
              
                TextColumn::make('montant_ttc')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state, 0, ',', ' ') . ' FCFA'),
                TextColumn::make('moyen_de_paiement'),
                 TextColumn::make('statut_paiement'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('type_support')
                    ->label('Type de support')
                    ->options([
                        'papier' => 'Papier',
                        'numerique' => 'Numérique',
                    ])
                    ->placeholder('Tous les supports'),

                \Filament\Tables\Filters\SelectFilter::make('format')
                    ->label('Format')
                    ->options([
                        'A0+' => 'A0+',
                        'A0' => 'A0',
                        'A3' => 'A3',
                        'A4' => 'A4',
                        'image' => 'Image',
                    ])
                    ->placeholder('Tous les formats'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // PDF
                Action::make('downloadPdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document')
                    ->action(function ($record) {
                        $pdf = Pdf::loadView('exports.commande_pdf', [
                            'commande' => $record,
                        ]);

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            "commande-{$record->id}.pdf"
                        );
                    }),

                // Excel
                Action::make('downloadExcel')
                    ->label('Excel')
                    ->icon('heroicon-o-document')
                    ->action(function ($record) {
                        return Excel::download(
                            new CommandeExport($record),
                            "commande-{$record->id}.xlsx"
                        );
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
