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
    //Function used while registering
    public static function fromRequest(array $data): self
    {
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            email: $data['email'],
            password: bcrypt($data['password']),  
        );
    }

    //Function used while logging in
    public static function fromLoginRequest(array $data): self
    {
        return new self(
            first_name: null,
            last_name: null,
            email: $data['email'],
            password: $data['password']  // Password is not hashed during login
        );
    }
    //Function used while getting the authors and their articles count 
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
    public function getFirstName()  { return  $this->first_name; } 
    
    public function getLastName()  { return  $this->last_name; } 

    public function getEmail()  { return  $this->email; }
    
    public function getPassword()  { return  $this->password; }

}
