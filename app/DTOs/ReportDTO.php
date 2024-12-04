<?php

namespace App\DTOs;
use App\Enums\ReportType;

class ReportDTO implements \JsonSerializable
{
    private ?int $user_id;
    private ?int $author_id;
    private string $description;
    private ReportType $type; // Use the ReportType enum

    public function __construct(
        ?string $user_id = null,
        ?string $author_id = null,
        string $description,
        ReportType $type = null
    ) {
        $this->user_id = $user_id;
        $this->author_id = $author_id;
        $this->description = $description;
        $this->type = $type;
      }
    //Function used while registering
    public static function fromRequest(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            author_id: $data['author_id'],
            description: $data['description'],
            type: $data['type']?? ReportType::OTHER  
        );
    }

    //Function used while logging in
        public function jsonSerialize(): array
    {
        return [
            'user_id' => $this->user_id,
            'author_id' => $this->author_id,
            'description' => $this->description,
            'type' => $this->type,
        ];
    }
    public function getUserid()  { return  $this->user_id; } 
    
    public function getAuthorid()  { return  $this->author_id; } 

    public function getDescription()  { return  $this->description; }
    
    public function getType()  { return  $this->type; }

}
