<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticlesResource;
use App\Services\FetchService;
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct(private FetchService $fetchService , private FavoriteService $favoriteService) {}

    public function fetchAuthors(Request $request)
{
    $authors = $this->fetchService->fetchAllAuthors();

    return response()->json([
        'message' => 'Here are the authors',
        'authors' => $authors
    ], 200);
}

public function fetchArticles(Request $request)
{
    $articles = $this->fetchService->fetchAllArticles();
    return response()->json([
        'message' => 'Here are the articles',
       'articles' => ArticlesResource::collection($articles)
    ], 200);
}

public function fetchArticleByAuthor(Request $request)
{
    $articles = $this->fetchService->fetchArticlesByAuthor($request->id);
    $authorname = $this->fetchService->getAuthorByAuthorId($request->id);
    $authorName = $authorname->first_name; // Extract the first name
    return response()->json([
        'message' => 'The articles of author ' . $request->id.' named '.$authorName,
        'articles' => ArticlesResource::collection($articles)
    ],200);
}
    public function addToFavorites(Request $request)
    {
        $articleId = $request->input('article_id');

        if ($this->favoriteService->addArticleToFav($articleId)) {
            return response()->json(['message' => 'Article added to favorites successfully.'], 200);
        }

        return response()->json(['message' => 'Article is already in favorites.'], 400);
    }

    public function removeFromFavorites(Request $request)
    {
        $articleId = $request->input('article_id');

        if ($this->favoriteService->removeArticleFromFav($articleId)) {
            return response()->json(['message' => 'Article removed from favorites successfully.'], 200);
        }

        return response()->json(['message' => 'Article was not in favorites.'], 400);
    }
    public function getFavorites(Request $request)
    {
        $articles = $this->favoriteService->fetchfavoriteArticles($request->id);
        dd($articles);
         return response()->json([
        'message' => 'Here are your favorite articles',
       'articles' => ArticlesResource::collection($articles)
    ], 200);
    }

}
