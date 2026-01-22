<?php

namespace App\Mail;

use App\Models\BecomeDealer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Queue\ShouldQueue; // enable if you have queues set up

class DealerFormMail extends Mailable /* implements ShouldQueue */
{
    use Queueable, SerializesModels;

    public BecomeDealer $dealer;

    public function __construct(BecomeDealer $dealer)
    {
        $this->dealer = $dealer;
    }

    public function build()
    {
        return $this->subject('New Become A Dealer Form Submission')
            ->replyTo($this->dealer->email, $this->dealer->name)     // helps with replies
            ->view('emails.dealer_form')
            ->with([
                'dealer' => $this->dealer,                           // expose as $dealer
            ]);
    }
}
