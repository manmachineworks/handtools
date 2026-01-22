<?php

namespace App\Mail;

use App\Models\ApplyForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ApplyForm $record) {}

    public function build()
    {
      return $this->subject('New Enquiry (Apply Form)')
        ->replyTo($this->record->email, $this->record->name)
        ->markdown('emails.apply-form', ['record' => $this->record]);
    }
}
