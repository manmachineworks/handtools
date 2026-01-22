<?php

namespace App\Mail;

use App\Models\BecomeDealer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealerFormAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public BecomeDealer $record) {}

    public function build()
    {
      return $this->subject('We received your dealer request')
        ->markdown('emails.dealer-form-autoreply', ['record' => $this->record]);
    }
}
