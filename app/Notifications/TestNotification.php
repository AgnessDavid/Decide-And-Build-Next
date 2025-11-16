<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Test notification',
            'body' => 'Ceci est un test',
            'format' => 'filament',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
        ];
    }
}