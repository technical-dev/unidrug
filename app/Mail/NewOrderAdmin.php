<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuoteRequest $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Order #ORD-' . str_pad($this->order->id, 5, '0', STR_PAD_LEFT),
            replyTo: [$this->order->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-admin',
        );
    }
}
