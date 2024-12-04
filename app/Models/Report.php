<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'author_id', 'description', 'type'];

    protected $casts = [
        'type' => 'integer', 
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
