<?php

namespace App\DTOs;

class AuthorDTO implements \JsonSerializable
{
    private ?string $first_name;
    private ?string $last_name;
    private string $email;
    private ?string $password;
    private ?int $articles_count;

    public function __construct(
        ?string $first_name = null,
        ?string $last_name = null,
        string $email,
        ?string $password = null,
        ?int $articles_count = null
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->articles_count = $articles_count;
    }

    public static function fromGetAuthorsRequest(array $data): self
    {
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            email: $data['email'],
            articles_count: $data['articles_count'] ?? 0
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'articles_count' => $this->articles_count,
        ];
    }
}
