<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $replyMessage;
    public $originalContact; // Bu ýerde müşderiniň maglumatlary bolar

    public function __construct($replyMessage, $originalContact)
    {
        $this->replyMessage = $replyMessage;
        $this->originalContact = $originalContact;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Perfume Art - Hatyňyza jogap',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.contact-reply',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
