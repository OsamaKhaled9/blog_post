<?php 
namespace App\Repositories;

use App\DTOs\AuthorDTO;
use App\Enums\ArticleStatus;
use App\Models\Author;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\Article;
class AuthorRepository
{
    /*public function createWithVerificationToken(AuthorDTO $authorDTO, string $verificationToken): Author
    {
        return Author::create([
            'first_name' => $authorDTO->getFirstName(),
            'last_name' => $authorDTO->getLastName(),
            'email' => $authorDTO->getEmail(),
            'password' => $authorDTO->getPassword(),
            'verification_token' => $verificationToken,
            'is_verified' => false // Set initial verification status to false
        ]);
    }*/
    public function findAuthorsArticles()
    {
        return Author::withCount([
            'articles as articles_count' => function ($query) {
            $query->where('status', 2); // Assuming status = 2 indicates "published"
            }
         ])->get();
    }
    
    public function findAllArticles()//need to be edited 
    {
        return Article::
            with(['author'])
            ->paginate(100);
    }
    
    /**************************************************************************************************** */
    public function fetchArticlesByAuthor($author_id)
    {
        return Article::where('author_id', $author_id)->paginate(10);
    }
    /**************************************************************************************************** */
    public function findVerifiedByEmail(string $email): ?Author
    {
        return Author::where('email', $email)
            ->where('is_verified', true)
            ->first();
    }
    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function findByEmail(string $email): ?Author
    {
        return Author::where('email', $email)->first();
    }

    public function findByToken(string $token): ?Author
    {
        return Author::where('verification_token', $token)->first();
    }
    public function findAuthorById($author_id)
{
    return Author::select('first_name')->find($author_id);
}
}
