<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceivedCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Unidrug order has been received',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-customer',
        );
    }
}
