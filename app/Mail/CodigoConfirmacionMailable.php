<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SplSubject;

class CodigoConfirmacionMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //Con mailtrap
        // return $this->subject('Correo de confirmación')->view('proveedores.matriz_escalamiento.perfil_correo_confirmacion');

        //Con gmail
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('proveedores.matriz_escalamiento.perfil_correo_confirmacion')
            ->subject('Correo de confirmación')
            ->with($this->mailData);
    }
}