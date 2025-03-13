<?php

namespace App\Mail;

use App\Helpers\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RecapMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->data['type'] == 'pdf') {
            $year = Helper::getYear();
            $newName = 'RECAPITULATIF_ANNUEL_DES_FRAIS_COMMISSIONS_' . $year.'pdf';
            // dd(Storage::disk('appsfile')->get($this->data['path'].$this->data['filename']));
            return $this->subject($this->data['title'])->markdown('mail.dec15m')->with('data', $this->data)
                ->attachData(
                    Storage::disk($this->data['disk'])->get($this->data['path'] . $this->data['filename']),
                    $newName,
                    // basename($this->data['filename']),
                    [
                        'mime' => 'application/pdf',
                    ]
                );
        }

        if ($this->data['type'] == 'xls') {
            return $this->subject($this->data['title'])->markdown('mail.dec15m')->with('data', $this->data)
                ->attachData(
                    Storage::disk('appsfile')->get($this->data['filename']),
                    basename($this->data['filename']),
                    [
                        'mime' => 'text/xlsx',
                    ]
                );
        }
    }
}
