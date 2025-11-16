<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CARTE-CIGN - Rapport Caisses</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            font-size: 12px; 
            color: #333;
            margin: 20px;
            background-color: #fff;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
        }
        h1 { 
            color: #007bff; 
            font-size: 24px; 
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .generation-date {
            font-style: italic;
            color: #666;
            margin: 0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px 10px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #007bff; 
            color: white; 
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tbody tr:hover {
            background-color: #e3f2fd;
        }
        h2 { 
            font-size: 16px; 
            margin: 30px 0 15px 0;
            color: #007bff;
            border-left: 4px solid #007bff;
            padding-left: 10px;
        }
        .products-table { 
            margin-left: 20px; 
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .products-table th {
            background-color: #0056b3;
        }
        .currency {
            text-align: right;
            font-weight: bold;
        }
        .percentage {
            text-align: center;
        }
        .status {
            text-align: center;
            font-weight: bold;
        }
        .status.paid {
            color: #28a745;
        }
        .status.unpaid {
            color: #dc3545;
        }
        .page-break { 
            page-break-before: always; 
        }
        @media print {
            body { margin: 0; }
            .page-break { page-break-before: always; }
            table { page-break-inside: avoid; }
        }
        /* Footer for print */
        @page {
            margin: 1in;
            @bottom-center {
                content: "Rapport généré par CARTE-CIGN - Page " counter(page);
                font-size: 10px;
                color: #999;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CARTE-CIGN - Rapport Caisses</h1>
        <p class="generation-date">Généré le : {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>N° Commande</th>
                <th>Client</th>
                <th class="currency">Montant HT</th>
                <th class="percentage">TVA</th>
                <th class="currency">Montant TTC</th>
                <th class="currency">Entrée</th>
                <th class="currency">Sortie</th>
                <th class="status">Statut Paiement</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    <td>{{ $record->user->name ?? 'N/A' }}</td>
                    <td><strong>{{ $record->numero_commande ?? 'N/A' }}</strong></td>
                    <td>{{ $record->nom_client ?? 'N/A' }}</td>
                    <td class="currency">{{ number_format($record->montant_ht, 2, ',', ' ') }} €</td>
                    <td class="percentage">{{ number_format($record->tva, 2, ',', ' ') }} %</td>
                    <td class="currency">{{ number_format($record->montant_ttc, 2, ',', ' ') }} €</td>
                    <td class="currency">{{ number_format($record->entree, 2, ',', ' ') }} €</td>
                    <td class="currency">{{ number_format($record->sortie, 2, ',', ' ') }} €</td>
                    <td class="status {{ strtolower($record->statut_paiement) === 'payé' ? 'paid' : 'unpaid' }}">{{ $record->statut_paiement }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($records as $index => $record)
        @if (!empty($record->produits_commande))
            <div @if ($index > 0) class="page-break" @endif>
                <h2>Détails des produits pour la commande {{ $record->numero_commande ?? 'N/A' }}</h2>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th style="text-align: center;">Quantité</th>
                            <th class="currency">Prix unitaire HT</th>
                            <th class="currency">Montant HT</th>
                            <th class="currency">Montant TTC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->produits_commande as $produit)
                            <tr>
                                <td><strong>{{ $produit['nom'] ?? 'N/A' }}</strong></td>
                                <td style="text-align: center;">{{ $produit['quantite'] }}</td>
                                <td class="currency">{{ number_format($produit['prix_unitaire_ht'], 2, ',', ' ') }} €</td>
                                <td class="currency">{{ number_format($produit['montant_ht'], 2, ',', ' ') }} €</td>
                                <td class="currency">{{ number_format($produit['montant_ttc'], 2, ',', ' ') }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach
</body>
</html>
