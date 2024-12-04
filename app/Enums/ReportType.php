<?php 
namespace App\Enums;

enum ReportType: int
{
    case SPAM = 1;
    case HARASSMENT = 2;
    case ABUSE = 3;
    case OTHER = 4;
}
