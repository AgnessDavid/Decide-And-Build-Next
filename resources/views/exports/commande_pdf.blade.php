{{-- resources/views/exports/commande_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Commande #{{ $commande->numero_commande }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            font-size: 14px; 
            line-height: 1.4; 
            color: #333;
            margin: 20px;
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
        }
        h1 { 
            color: #007bff; 
            font-size: 28px; 
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin: 20px 0;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .info-section {
            flex: 1;
            min-width: 200px;
            margin: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            display: block;
            margin-bottom: 5px;
        }
        .info-value {
            color: #212529;
            font-size: 15px;
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
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tbody tr:hover {
            background-color: #e3f2fd;
        }
        .currency {
            text-align: right;
            font-weight: bold;
        }
        .quantity {
            text-align: center;
        }
        h3 { 
            font-size: 18px; 
            margin: 30px 0 15px 0;
            color: #007bff;
            border-left: 4px solid #007bff;
            padding-left: 10px;
        }
        .totals {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-top: 20px;
        }
        .totals p {
            margin: 10px 0;
            font-size: 16px;
        }
        .totals .label {
            font-weight: bold;
            color: #495057;
            display: inline-block;
            width: 150px;
        }
        .totals .value {
            color: #212529;
            font-weight: bold;
        }
        @media print {
            body { margin: 0; }
            table { page-break-inside: avoid; }
            .invoice-info { page-break-inside: avoid; }
            .totals { page-break-inside: avoid; }
        }
        /* Footer for print */
        @page {
            margin: 1in;
            @bottom-center {
                content: "Commande générée par CARTE-CIGN - Page " counter(page);
                font-size: 10px;
                color: #999;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture Commande #{{ $commande->numero_commande }}</h1>
    </div>

    <div class="invoice-info">
        <div class="info-section">
            <span class="info-label">Client :</span>
            <span class="info-value">{{ $commande->client->nom ?? 'Inconnu' }}</span>
        </div>
        <div class="info-section">
            <span class="info-label">Agent :</span>
            <span class="info-value">{{ $commande->user->name ?? 'Inconnu' }}</span>
        </div>
        <div class="info-section">
            <span class="info-label">Date :</span>
            <span class="info-value">{{ $commande->date_commande->format('d/m/Y') }}</span>
        </div>
    </div>

    <h3>Produits commandés</h3>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th class="quantity">Quantité</th>
                <th class="currency">Prix unitaire (HT)</th>
                <th class="currency">Montant (HT)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->produits as $ligne)
                <tr>
                    <td><strong>{{ $ligne->produit->nom_produit ?? 'N/A' }}</strong></td>
                    <td class="quantity">{{ $ligne->quantite }}</td>
                    <td class="currency">{{ number_format($ligne->prix_unitaire_ht, 0, ',', ' ') }} FCFA</td>
                    <td class="currency">{{ number_format($ligne->montant_ht, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <h3 style="margin-top: 0; color: #007bff;">Totaux</h3>
        <p><span class="label">Produit non satisfait :</span> <span class="value">{{ number_format($commande->produit_non_satisfait, 0, ',', ' ') }} Produit</span></p>
        <p><span class="label">Total HT :</span> <span class="value">{{ number_format($commande->montant_ht, 0, ',', ' ') }} FCFA (SANS TVA)</span></p>
        <p><span class="label">TVA :</span> <span class="value"> {{ number_format($commande->montant_ttc, 0, ',', ' ') }} ({{ $commande->tva ?? 18 }} % )FCFA (AVEC LA TVA)</span></p>
        <p><span class="label">Total TTC :</span> <span class="value">{{ number_format($commande->montant_ttc, 0, ',', ' ') }} FCFA </span></p>
    </div>
</body>
</html>