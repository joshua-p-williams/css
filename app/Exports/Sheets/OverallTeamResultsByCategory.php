<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\OverallTeamRanking;

class OverallTeamResultsByCategory implements FromQuery, WithTitle, WithHeadings
{
    private $categoryId;
    private $categoryName;

    public function __construct(int $categoryId, string $categoryName)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
    }

    public function query()
    {
        return OverallTeamRanking::select('category_name', 'team_name', 'ranking', 'score', 'tie_breaker_1', 'tie_breaker_2', 'tie_breaker_3', 'tie_breaker_4')
                                ->ByCategoryId($this->categoryId)
                                ->OrderByWinner();
    }    

    public function title(): string
    {
        return substr($this->categoryName . ' Overall', 0, 30);
    }

    public function headings(): array
    {
        return ["Category", "Team", "Ranking", "Score", "Tie Breaker 1", "Tie Breaker 2", "Tie Breaker 3", "Tie Breaker 4"];
    }
}
