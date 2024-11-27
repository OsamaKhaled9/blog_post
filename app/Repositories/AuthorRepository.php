<?php 
namespace App\Repositories;

use App\DTOs\AuthorDTO;
use App\Models\Author;
//Deals with the Database
class AuthorRepository {

    public function create(AuthorDTO $authorDTO): Author
        {
    // Use the properties directly from AuthorDTO
            return Author::create([
                'first_name' => $authorDTO->getFirstName(),
                'last_name' => $authorDTO->getLastName(),
                'email' => $authorDTO->getEmail(),
                'password' => $authorDTO->getPassword(),
            ]);
        }

    
    public function findByEmail(string $email): ?Author //ORM query for author email
        {
            return Author::where('email', $email)->first();
        }

}