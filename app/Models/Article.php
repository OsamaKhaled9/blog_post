<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ArticleStatus;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'author_id',
    ];

    protected $casts = [
        'status' => ArticleStatus::class,
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    
    public function authors() {
        return $this->belongsToMany(Author::class, 'article_author', 'article_id', 'author_id');
    }

}
