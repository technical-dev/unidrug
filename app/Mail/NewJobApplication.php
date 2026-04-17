<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewJobApplication extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobApplication $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Application: ' . $this->application->position . ' — ' . $this->application->full_name,
            replyTo: [$this->application->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.job-application',
        );
    }
}
