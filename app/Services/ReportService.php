<?php
namespace App\Services;

use App\Repositories\ReportRepository;
use App\Models\User;
use App\DTOs\ReportDTO;
use Illuminate\Support\Facades\Auth;
use App\Enums\ReportType;

class ReportService
{
    public function __construct(
        private ReportRepository $reportRepository
    ) {}

    public function createReport($user, array $data): void
{
    $type = match (strtolower($data['type'])) {
        'spam' => ReportType::SPAM,
        'harassment' => ReportType::HARASSMENT,
        'abuse' => ReportType::ABUSE,
        'other' => ReportType::OTHER,
        default => 0,
    };      
    $user = Auth::user();
    
    $reportDTO = new ReportDTO(
        user_id: $user->id,
        author_id: $data['author_id'],
        description: $data['description'],
        type: $type // Pass the enum instance
    );
    //dd($reportDTO);

    $this->reportRepository->storeReport($reportDTO);

}
/*
<?php


class ReportService
{
    public function __construct(
        private ReportRepository $reportRepository
    ) {}

    public function createReport($user,array $data): void
    {
        //dd($data);
        // Convert type to ReportType enum
        $type = match (strtolower($data['type'])) {
            'spam' => ReportType::SPAM,
            'harassment' => ReportType::HARASSMENT,
            'abuse' => ReportType::ABUSE,
            'other' => ReportType::OTHER,
            default => 0,
        };      
   

        // Create a DTO
        $reportDTO = new ReportDTO(
            user_id: $user->id,
            author_id: $data['author_id'],
            description: $data['description'],
            type: $type // Pass the enum instance
        );
        dd($reportDTO);


        // Call the repository to store the report
        $this->reportRepository->storeReport($reportDTO);
    }

    
}*/

    
}