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

    protected $user;
    protected $socio;
    protected $filePath;

    public function __construct($user, $socio, $filePath)
    {
        $this->user = $user;
        $this->socio = $socio;
        $this->filePath = $filePath;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $absolutePath = Storage::disk('public')->path($this->filePath);

        return (new MailMessage)
            ->subject('Contrato de Registro - Caja Popular San Juan Bosco')
            ->greeting('Hola ' . $this->user->name . ' ' . $this->socio->apellido_paterno . ' ' . $this->socio->apellido_materno)
            ->line('Adjunto encontrarás tu contrato de registro como socio de la Caja Popular San Juan Bosco.')
            ->line('Por favor conserva este documento para tus registros.')
            ->attach($absolutePath, [
                'as' => 'Contrato_' . $this->socio->numero_socio . '.pdf',
                'mime' => 'application/pdf',
            ])
            ->line('Gracias por confiar en nosotros.');
    }
}
