<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewServiceRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ServiceRequest $serviceRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Service Request: ' . ucfirst($this->serviceRequest->service_type),
            replyTo: [$this->serviceRequest->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.service-request',
        );
    }
}
