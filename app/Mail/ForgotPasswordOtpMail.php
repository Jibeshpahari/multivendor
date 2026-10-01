<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;


    public string $subjectText;
    public string $htmlContent;

    public function __construct($templateId,  $keywordValues = [])
    {
        $template = EmailTemplate::find($templateId);
        if (!$template) { throw new Exception('Template not found.'); }

        $keywords = array_map('trim', explode(',', $template->keywords ?? ''));

        $this->subjectText = str_replace($keywords, $keywordValues, $template->subject);
        $this->htmlContent = str_replace($keywords, $keywordValues, $template->content);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.template',
            with: [
                'html' => $this->htmlContent,
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
