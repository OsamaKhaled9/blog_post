<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticlesResource;
use App\Services\FetchService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct(private FetchService $fetchService) {}

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
}
