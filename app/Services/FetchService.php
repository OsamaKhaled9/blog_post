<?php
namespace App\Services;

use App\DTOs\AuthorDTO;
use App\Repositories\AuthorRepository;

class FetchService
{
    public function __construct(
        private AuthorRepository $authorRepository
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

}
