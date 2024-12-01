<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 authors, each with exactly 50 articles
        $authors = Author::factory()
            ->count(10)
            ->create();

        // For each author, create 50 articles and attach to article_author
        $authors->each(function ($author) {
            $articles = Article::factory()
                ->count(50)
                ->for($author, 'author')
                ->create();

            // Attach each article to its author in the article_author pivot table
            $articles->each(function ($article) use ($author) {
                $article->authors()->attach($author->id);
            });
        });
    }
}