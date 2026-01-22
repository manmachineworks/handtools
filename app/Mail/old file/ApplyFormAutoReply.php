<?php

namespace App\Mail;

use App\Models\ApplyForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyFormAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ApplyForm $record) {}

    public function build()
    {
      return $this->subject('We received your enquiry')
        ->markdown('emails.apply-form-autoreply', ['record' => $this->record]);
    }
}
