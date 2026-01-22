<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $formData;

    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    public function build()
    {
        return $this->subject('New Apply/Quote Form Submission')
                    ->view('emails.quote-form')   // resources/views/emails/quote-form.blade.php
                    ->with(['formData' => $this->formData]);
    }
}
