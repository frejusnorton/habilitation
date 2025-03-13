<?php

namespace App\Mail;

use App\Helpers\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NotifMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $validateur;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($demande, $validateur)
    {
        $this->demande = $demande;
        $this->validateur = $validateur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Nouvelle demande en attente de validation')
            ->view('mail.demande')
            ->with([
                'demande' => $this->demande,
                'validateur' => $this->validateur,
            ]);
    }
}
