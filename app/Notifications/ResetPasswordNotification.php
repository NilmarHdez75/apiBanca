<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    protected function resetUrl($notifiable)
    {
        return 'cajapopular://reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->getEmailForPasswordReset());
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Restablecer contraseña')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Recibiste este correo porque solicitaste restablecer tu contraseña.')
            ->action('Restablecer contraseña', $this->resetUrl($notifiable))
            ->line('Si no realizaste esta solicitud, no es necesario hacer nada.')
            ->salutation('Saludos, Caja Popular San Juan Bosco');
    }
}
