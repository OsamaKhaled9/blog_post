<?php
namespace App\Services;

use App\Repositories\FavoriteRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function __construct(
        private FavoriteRepository $favoriteRepository
    ) {}

    public function addArticleToFav(int $articleId): bool
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            throw new \Exception('User is not authenticated.');
        }

        return $this->favoriteRepository->addArticleToFav($user, $articleId);
    }

    public function removeArticleFromFav(int $articleId): bool
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            throw new \Exception('User is not authenticated.');
        }

        return $this->favoriteRepository->removeArticleFromFav($user, $articleId);
    }
    public function fetchfavoriteArticles($id)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            throw new \Exception('User is not authenticated.');
        }

        return $this->favoriteRepository->fetchFavoriteArticles($user,$id);
    }
}
