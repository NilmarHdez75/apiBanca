<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailCustom extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    protected function verificationUrl($notifiable)
    {
        $path = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ],
            absolute: false
        );

        return url($path);
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifica tu correo')
            ->line('Por favor verifica tu dirección de correo electrónico.')
            ->action('Verificar correo', $this->verificationUrl($notifiable))
            ->line('Gracias por usar nuestra aplicación.');
    }
}
