<?php 

namespace App\DTOs;

class AuthorDTO
{
    private ?string $first_name;
    private ?string $last_name;
    private string $email;
    private string $password;

    public function __construct(?string $first_name, ?string $last_name, string $email, string $password)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;  // password is already hashed by bcrypt()
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            email: $data['email'],
            password: bcrypt($data['password']),  
        );
    }
    public static function fromLoginRequest(array $data): self
    {
        return new self(
            first_name: null,
            last_name: null,
            email: $data['email'],
            password: $data['password']  // Password is not hashed during login
        );
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}
