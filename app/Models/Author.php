<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Author extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'verification_token', // Add this line
        'is_verified',
        
    ];    
    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected $casts = [
        "password"=> "hashed",
    ];

    /*public function articles()
    {
        return $this->hasMany(Article::class);
    }*/

    public function articles() {
        return $this->belongsToMany(Article::class, 'article_author', 'author_id', 'article_id');
    }
}
