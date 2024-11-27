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
        return $this->view('emails.verification')
            ->subject('Email Verification')
            ->with(['author' => $this->author]);
    }
}
