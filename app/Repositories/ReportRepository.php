<?php 
namespace App\Repositories;

use App\Models\Report;
use App\DTOs\ReportDTO;

class ReportRepository
{
  
    public function storeReport(ReportDTO $reportDTO): void
    {
        //dd($reportDTO->getType()->value);
        Report::create([ // Correct usage of the Report model
            'user_id' => $reportDTO->getUserId(),
            'author_id' => $reportDTO->getAuthorId(),
            'description' => $reportDTO->getDescription(),
            'type' => $reportDTO->getType()->value, 
        ]);
    }
}
