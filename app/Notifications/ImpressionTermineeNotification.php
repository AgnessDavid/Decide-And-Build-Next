<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ImpressionTermineeNotification extends Notification
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
            'title' => 'Impression terminée',
            'body' => "L'impression {$this->numeroImpression} a été ajoutée à la Gestion Imprimerie.",
            'format' => 'filament',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'expires_at' => now()->addHours(2)->toDateTimeString(), // Expire dans 2 heures
        ];
    }
}