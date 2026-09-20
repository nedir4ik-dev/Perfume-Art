<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Hatynyn ady (Subject) barada maglumat.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✨ Perfume-Art Collection | Sargydyňyz Kabul Edildi! #' . $this->order->order_number,
        );
    }

    /**
     * Hatynyn içeriği (Blade şablony).
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_accepted', // resources/views/emails/order_accepted.blade.php
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
