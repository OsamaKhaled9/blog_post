<?php
namespace App\Services;

use App\DTOs\AuthorDTO;
use App\Jobs\SendVerificationEmail;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class AuthService
{
    public function __construct(
        private AuthorRepository $authorRepository
    ) {}

    public function register(AuthorDTO $authorDTO): array
    {
        $existingAuthor = $this->authorRepository->findByEmail($authorDTO->getEmail());
        if ($existingAuthor) {
            throw new \Exception('Email already exists');
        }

        // Generate the verification token
        $verificationToken = Str::random(60);

        // Create the author with the verification token
        $author = $this->authorRepository->createWithVerificationToken($authorDTO, $verificationToken);
        
        // Dispatch the email verification job
        dispatch(new SendVerificationEmail($author));

        // Return the newly created author and token (authentication token for API)
        $token = $author->createToken('auth_token')->plainTextToken;
        return [
            'author' => $author,
            'token' => $token,
        ];
    }
}
