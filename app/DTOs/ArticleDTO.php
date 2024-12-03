<?php

namespace App\DTOs;

use App\Enums\ArticleStatus;

class ArticleDTO implements \JsonSerializable
{
    private ?string $title;
    private ?string $description;
    private ?int $status;
    private ?int $author_id;

    public function __construct(
        ?string $title = null,
        ?string $description = null,
        ?int $status = 0,
        ?int $author_id = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->author_id = $author_id;
    }
public static function fromGetArticleRequest(array $data):self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            status: $data['status'],
            author_id: $data['author_id'],
        );
    }
public function jsonSerialize(): array
{
    return [
        'title' => $this->title,
        'description' => $this->description,
        //'status' => $this->status,
        'author_id' => $this->author_id,
    ];
}
}