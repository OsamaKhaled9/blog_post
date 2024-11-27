<?php
namespace App\Services;

use App\DTOs\AuthorDTO;
use App\Jobs\SendVerificationEmail;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use Illuminate\Auth\Events\Registered;


class AuthService
{
    public function __construct(
        private AuthorRepository $authorRepository
    ) {}

    public function register(AuthorDTO $authorDTO): array
    {
        //dd($authorDTO); // Ensure the DTO is correct before further processing
        $existingAuthor = $this->authorRepository->findByEmail($authorDTO->getEmail());
        if ($existingAuthor) {
            throw new \Exception('Email already exists');
        }

        $author = $this->authorRepository->create($authorDTO);
        event(new Registered( $author));
        dispatch(new SendVerificationEmail($author));

        $token = $author->createToken('auth_token')->plainTextToken;
        

        return [
            'author' => $author,
            'token' => $token,
        ];
    }
}