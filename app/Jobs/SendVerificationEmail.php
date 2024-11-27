<?php 
// app/Jobs/SendVerificationEmail.php
namespace App\Jobs;

use App\Mail\VerificationEmail;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Author $author
    ) {}

    public function handle(): void
    {
        Mail::to($this->author->email)->send(new VerificationEmail($this->author));
    }
}