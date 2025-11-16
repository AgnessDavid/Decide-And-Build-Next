<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FicheValideeNotification extends Notification
{
    use Queueable;

    public $numeroImpression;

    public function __construct($numeroImpression)
    {
        $this->numeroImpression = $numeroImpression;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Fiche validée avec succès',
            'body' => "L'impression {$this->numeroImpression} a été créée suite à la validation.",
            'format' => 'filament',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
        ];
    }
}