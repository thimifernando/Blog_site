<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BlogPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $blog;
    public $senderName;
    public $senderEmail;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $blog
     * @param  string  $senderName
     * @param  string  $senderEmail
     * @return void
     */
    public function __construct($blog, $senderName, $senderEmail)
    {
        $this->blog = $blog;
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Blog Posted',
            from: $this->senderEmail, // Set the sender's email address
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.blog_posted', // Update with the correct view name
            with: [
                'blog' => $this->blog,
                'senderName' => $this->senderName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
