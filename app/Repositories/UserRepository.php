<?php 
namespace App\Repositories;

use App\DTOs\AuthorDTO;
use App\DTOs\UserDTO;
use App\Enums\ArticleStatus;
use App\Models\Author;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\User;
class UserRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function createWithVerificationToken(UserDTO $userDTO, string $verificationToken): User
    {
        return User::create([
            'name' => $userDTO->getName(),
            'email' => $userDTO->getEmail(),
            'password' => $userDTO->getPassword(),
            //'verification_token' => $verificationToken,
        ]);
    }
    public function findVerifiedByEmail(string $email): ?User
    {
        return User::where('email', $email)
        ->whereNotNull('email_verified_at')
        ->first();
    }
    public function findByToken(string $email): ?User
    {
        //dd($email);
        return User::where('email', $email)->first();
    }
}