<?php 
namespace App\Repositories;

use App\DTOs\AuthorDTO;
use App\Models\Author;

class AuthorRepository
{
    public function createWithVerificationToken(AuthorDTO $authorDTO, string $verificationToken): Author
    {
        return Author::create([
            'first_name' => $authorDTO->getFirstName(),
            'last_name' => $authorDTO->getLastName(),
            'email' => $authorDTO->getEmail(),
            'password' => $authorDTO->getPassword(),
            'verification_token' => $verificationToken,
            'is_verified' => false // Set initial verification status to false
        ]);
    }

    public function findByEmail(string $email): ?Author
    {
        return Author::where('email', $email)->first();
    }

    public function findByToken(string $token): ?Author
    {
        return Author::where('verification_token', $token)->first();
    }
}
