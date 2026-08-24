<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $senderName = $this->contactData['name'] ?? 'Website Inquiry';
        $productName = $this->contactData['product_name'] ?? null;
        $subjectPrefix = 'New Website Inquiry';

        if ($productName) {
            $subjectPrefix = 'New Product Demo Request (' . $productName . ')';
        } elseif (isset($this->contactData['attachment']) && !empty($this->contactData['attachment'])) {
            $subjectPrefix = 'New Job Application';
        }

        return new Envelope(
            subject: $subjectPrefix . ': ' . $senderName,
            replyTo: [
                new Address($this->contactData['email'], $senderName)
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'data'        => $this->contactData,
                'contactData' => $this->contactData
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if (!empty($this->contactData['attachment']) && !empty($this->contactData['attachment']['base64'])) {
            $fileData = base64_decode($this->contactData['attachment']['base64']);
            $fileName = $this->contactData['attachment']['name'] ?? 'Resume.pdf';
            $mimeType = $this->contactData['attachment']['mime_type'] ?? 'application/pdf';

            $attachments[] = Attachment::fromData(fn () => $fileData, $fileName)
                ->as($fileName)
                ->withMime($mimeType);
        }

        return $attachments;
    }
}
