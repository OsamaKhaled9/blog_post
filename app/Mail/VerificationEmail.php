<?php 

namespace App\Mail;

use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Author $author) {}

    public function build()
    {
        return $this->subject('Email Verification')
                    ->html($this->getVerificationEmailContent());
    }

    private function getVerificationEmailContent(): string
    {
        $verificationUrl = url('/api/verify-email?token=' . $this->author->verification_token);

        return "<p>Hello {$this->author->first_name},</p>
                <p>Please click the link below to verify your email:</p>
                <p><a href='{$verificationUrl}'>Verify Email</a></p>";
    }
}
