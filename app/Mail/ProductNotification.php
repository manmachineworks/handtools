<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $productName;
    public $productUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productName, $productUrl)
    {
        $this->productName = $productName;
        $this->productUrl = $productUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Product Available: ' . $this->productName)
            ->view('emails.product_notification');
    }
}
