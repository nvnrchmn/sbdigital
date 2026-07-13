<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyTenantEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tenantRegistration;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\TenantRegistration $tenantRegistration)
    {
        $this->tenantRegistration = $tenantRegistration;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Pendaftaran Tenant - SBDigital',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-tenant',
            with: [
                'verificationUrl' => route('tenant.verify', ['token' => $this->tenantRegistration->token]),
                'namaPerumahan' => $this->tenantRegistration->nama_perumahan,
                'adminName' => $this->tenantRegistration->admin_name,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
