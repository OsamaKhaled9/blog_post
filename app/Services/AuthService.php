<?php
namespace App\Services;

use App\DTOs\AuthorDTO;
use App\DTOs\UserDTO;
use App\Jobs\SendVerificationEmail;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class AuthService 
{
    public function __construct(
        private UserRepository $UserRepository
    ) {}

    public function register(UserDTO $userDTO): array
    {
        $existingUser = $this->UserRepository->findByEmail($userDTO->getEmail());
        if ($existingUser) {
            throw new \Exception('Email already exists');
        }

        // Generate the verification token
        $verificationToken = Str::random(60);

        // Create the user with the verification token
        $user = $this->UserRepository->createWithVerificationToken($userDTO, $verificationToken);
        
        // Dispatch the email verification job
        dispatch(new SendVerificationEmail($user));

        // Return the newly created author and token (authentication token for API)
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
