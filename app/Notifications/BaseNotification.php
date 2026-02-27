<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Define the notification delivery channels.
     *
     * @return array<int, string> List of channels (mail)
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
}
