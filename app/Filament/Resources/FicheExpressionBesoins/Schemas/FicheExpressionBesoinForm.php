<?php  

namespace App\Filament\Resources\FicheExpressionBesoins\Schemas;  

use Filament\Forms\Components\TextInput;  
use Filament\Forms\Components\Select;  
use Filament\Forms\Components\Textarea;  
use Filament\Forms\Components\DatePicker;  
use Filament\Forms\Components\Toggle;  
use Filament\Schemas\Components\Section;  
use Filament\Schemas\Schema;  
use App\Models\Produit;  

class FicheExpressionBesoinForm  
{  
    public static function configure(Schema $schema): Schema  
    {  
        return $schema->components([  

            // 🔹 Infos Structure
            Section::make('Informations sur la structure')  
                ->schema([  
                    TextInput::make('nom_structure')->label('Nom de la structure')->required(),  
                    Select::make('type_structure')  
                        ->label('Type de structure')  
                        ->options([  
                            'societe' => 'Société',  
                            'organisme' => 'Organisme',  
                            'particulier' => 'Particulier',  
                        ])  
                        ->required(), 
                        
                     TextInput::make('nom_fiche_besoin')
                    ->label('Code de la fiche de besoin')
                    ->default(function () {
                     // Générer un code unique, ex : FB-2025-0001
                        $lastId = \App\Models\FicheBesoin::latest('id')->first()?->id ?? 0;
                        $nextId = $lastId + 1;
                        return 'FBC-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
                    })
                    ->disabled() // Empêche la modification manuelle
                    ->required(),

                    TextInput::make('nom_interlocuteur')
                    ->label('Nom de l’interlocuteur')
                    ->required(),  
                    TextInput::make('fonction')
                    ->label('Fonction'),  
                ])->columns(2),  

            // 🔹 Contacts
            Section::make('Contacts')  
                ->schema([  
                    TextInput::make('telephone')->label('Téléphone'),  
                    TextInput::make('cellulaire')->label('Cellulaire'),  
                    TextInput::make('fax')->label('Fax'),  
                    TextInput::make('email')->label('Email')->email(),  
                ])->columns(2),  

            // 🔹 Entretien
            Section::make('Entretien')  
                ->schema([  
                    TextInput::make('nom_agent_bnetd')->label('Nom de l’agent BNETD')->required(),  
                    DatePicker::make('date_entretien')->label('Date de l’entretien')->required(),  
                    Textarea::make('objectifs_vises')->label('Objectifs visés'),  
                    DatePicker::make('delai_souhaite')->label('Délai souhaité'),  
                    TextInput::make('signature_client')->label('Signature client'),  
                    TextInput::make('signature_agent_bnetd')->label('Signature agent BNETD'),  
                    DatePicker::make('date_livraison_prevue')->label('Date de livraison prévue'),  
                    DatePicker::make('date_livraison_reelle')->label('Date de livraison réelle'),  
                    Toggle::make('commande_ferme')->label('Commande fermée')->default(false),  
                    Toggle::make('demande_facture_proforma')->label('Demande de facture proforma')->default(false),  
                ])->columns(2),

           
        

            // 🔹 Informations cartographiques
            Section::make('Informations cartographiques')  
                ->schema([  
                    // titre du produit
                    TextInput::make('produit_souhaite')  
                    ->label('Titre de la carte')  
                    ->required(),  
                    TextInput::make('type_carte')->label('Type de carte'),
                    TextInput::make('echelle')->label('Échelle (ex: 1:50000)'),  
                    TextInput::make('orientation')->label('Orientation (ex: Nord)'),  
                    TextInput::make('auteur')->label('Auteur / Source'),  
                    TextInput::make('symbole')->label('Symbole'),  
                    TextInput::make('type_element')->label('Type d’élément (Relief, Hydrographie, Route...)'),  
                    TextInput::make('latitude')->label('Latitude'),  
                    TextInput::make('longitude')->label('Longitude'),  
                    TextInput::make('nom_zone')->label('Nom de la zone'),  
                    TextInput::make('type_zone')->label('Type de zone'),  
                    
                    TextInput::make('quantite_demandee')
                    ->label('Quantité demandée')
                    ->numeric()
                    ->default(0)

                ])->columns(2),  
        ]);  
    }  
}
