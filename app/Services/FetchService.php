<?php
namespace App\Services;

use App\DTOs\AuthorDTO;
use App\Repositories\AuthorRepository;
use App\DTOs\ArticleDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class FetchService
{
    public function __construct(
        private AuthorRepository $authorRepository,
    ) {}

    public function fetchAllAuthors(): array
    {
    $authors = $this->authorRepository->findAuthorsArticles();

    return $authors->map(function ($author) {
        return new AuthorDTO(
            first_name: $author->first_name,
            last_name: $author->last_name,
            email: $author->email,
            articles_count: $author->articles_count
        );
    })->toArray();
    }

    public function fetchAllArticles() 
    {
       return $this->authorRepository->findAllArticles();
       /* return $articles->map(function ($article) {
            return new ArticleDTO(
                title: $article->title,
                description : $article->description,
                //status : $article->status,
                author_id : $article->author_id,
            );
        })->toArray();*/

    }
    public function fetchArticlesByAuthor($authorId)
    {
        return $this->authorRepository->fetchArticlesByAuthor($authorId);
    }
    public function getAuthorByAuthorId($authorId)
    {
        return $this->authorRepository->findAuthorById($authorId);
    }
}
