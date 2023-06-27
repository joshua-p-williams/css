<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\IndividualRanking;

class IndividualResultsByCategoryAndEvent implements FromQuery, WithTitle, WithHeadings
{
    private $categoryId;
    private $categoryName;
    private $eventId;
    private $eventName;

    public function __construct(int $categoryId, string $categoryName, int $eventId, string $eventName)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->eventId = $eventId;
        $this->eventName = $eventName;
    }

    public function query()
    {
        return IndividualRanking::select('category_name', 'event_name', 'team_name', 'participant_name', 'ranking', 'score', 'tie_breaker_1', 'tie_breaker_2', 'tie_breaker_3', 'tie_breaker_4')
                                ->ByCategoryId($this->categoryId)
                                ->ByEventId($this->eventId)
                                ->OrderByWinner();
    }    

    public function title(): string
    {
        return substr($this->eventName . ' - ' . $this->categoryName, 0, 30);
    }

    public function headings(): array
    {
        return ["Category", "Event", "Team", "Participant", "Ranking", "Score", "Tie Breaker 1", "Tie Breaker 2", "Tie Breaker 3", "Tie Breaker 4"];
    }
}
