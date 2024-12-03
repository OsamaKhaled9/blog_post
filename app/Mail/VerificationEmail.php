<?php 

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function build()
    {
        return $this->subject('Email Verification')
                    ->html($this->getVerificationEmailContent());
    }

    private function getVerificationEmailContent(): string
    {
        $verificationUrl = url('/api/verify-email?email=' . $this->user->email);

        return "<p>Hello {$this->user->name},</p>
                <p>Please click the link below to verify your email:</p>
                <p><a href='{$verificationUrl}'>Verify Email</a></p>";
    }
}
