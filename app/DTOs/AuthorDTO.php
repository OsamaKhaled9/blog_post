<?php 

namespace App\DTOs;

use Password;

//there is an error with the readonly class (php version)
//I can remove the readonly and provide to the class only getters methods I think it should be the same.
//readonly class AuthorDTO
class AuthorDTO
{
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    public function __construct(string $first_name,string $last_name, string $email, string $password)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = bcrypt($password);
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            email: $data['email'],
            password: bcrypt($data['password'])
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