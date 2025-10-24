<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ContratoGeneradoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $socio;
    protected $filePath;

    public function __construct($socio, $filePath)
    {
        $this->socio = $socio;
        $this->filePath = $filePath;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $nombre = $this->socio->nombre . ' ' . $this->socio->apellidos;

        return (new MailMessage)
            ->subject('Contrato de Afiliación - Caja Popular San Juan Bosco')
            ->greeting("¡Bienvenido(a), {$nombre}!")
            ->line('Te damos la bienvenida a la Caja Popular San Juan Bosco.')
            ->line('Adjunto encontrarás tu contrato de afiliación en formato PDF.')
            ->attach(Storage::disk('public')->path($this->filePath))
            ->line('Por favor, conserva este documento como comprobante de tu registro.')
            ->line('Gracias por confiar en nosotros.')
            ->salutation('Atentamente, Caja Popular San Juan Bosco');
    }
}
