<?php

namespace App\DTOs;

use App\Abstracts\AbstractDTO;

class UserDTO extends AbstractDTO
{
    private ?string $name;
    private string $email;
    private ?string $password;


    public function __construct(?string $name = null,string $email,?string $password = null,)
     {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    //Function used while registering
    public static function fromRegisterRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],  
        );
    }

    //Function used while logging in
    public static function fromLoginRequest(array $data): self
    {
        return new self(
            name: null,
            //last_name: null,
            email: $data['email'],
            password: $data['password']  // Password is not hashed during login
        );
    }
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
    public function getname()  { return  $this->name; } 

    public function getEmail()  { return  $this->email; }
    
    public function getPassword()  { return  $this->password; }

}
