<?php 
namespace App\Enums;

enum ArticleStatus: int
{
    case DRAFT = 1;
    case PUBLISHED = 2;
    case ARCHIVED = 3;
}
