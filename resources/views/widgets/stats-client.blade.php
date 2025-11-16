<x-filament::card>
    <h2 class="text-lg font-bold mb-4">Informations du Client</h2>

    <ul class="space-y-2">
        <li><strong>Nom Complet:</strong> {{ $client->nom_complet }}</li>
        <li><strong>Type:</strong> {{ $client->type_label }}</li>
        <li><strong>Usage:</strong> {{ $client->usage_label }}</li>
        <li><strong>Interlocuteur:</strong> {{ $client->nom_interlocuteur }}</li>
        <li><strong>Téléphone:</strong> {{ $client->telephone }}</li>
        <li><strong>Cellulaire:</strong> {{ $client->cellulaire }}</li>
        <li><strong>Email:</strong> {{ $client->email }}</li>
        <li><strong>Ville:</strong> {{ $client->ville }}</li>
        <li><strong>Quartier:</strong> {{ $client->quartier_de_residence }}</li>
        <li><strong>Domaine d'activité:</strong> {{ $client->domaine_activite }}</li>
        <li><strong>Fiches de Besoin:</strong> {{ $client->fichesBesoin->count() }}</li>
        <li><strong>Paiements:</strong> {{ $client->paiements->count() }}</li>
    </ul>
</x-filament::card>
