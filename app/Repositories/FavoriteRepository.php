<?php 
namespace App\Repositories;

use App\DTOs\AuthorDTO;
use App\DTOs\UserDTO;
use App\Enums\ArticleStatus;
use App\Models\Author;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\User;
namespace App\Repositories;

use App\Models\User;
use App\Models\Article;

class FavoriteRepository
{

    public function AddArticleToFav(User $user, int $articleId): bool
    {
        // Check if the article already exists in favorites
        if ($user->favorites()->where('article_id', $articleId)->exists()) {
            return false; // Article already favorited
        }

        // Add the article to favorites
        $user->favorites()->attach($articleId);

        return true;
    }

    
     
    public function removeArticleFromFav(User $user, int $articleId): bool
    {
        // Check if the article exists in favorites
        if (!$user->favorites()->where('article_id', $articleId)->exists()) {
            return false; // Article is not in favorites
        }

        // Remove the article from favorites
        $user->favorites()->detach($articleId);

        return true;
    }

    public function fetchFavoriteArticles(User $user , $id)
    {
       // return $user->favorites()->where('user_id', $id)->first();
        return User::findOrFail($id)->favorites; // returns a collection of Article models, not a single instance.
    }
}
