<?php

namespace App\Http\Controllers\Api\V1;

use App\Event;
use App\Category;
use App\TeamRanking;
use App\Participant;
use App\IndividualRanking;
use App\OverallRanking;
use App\OverallTeamRanking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class CeremonyResultsController extends Controller
{
    public function index(Request $request)
    {
        return $this->byEvent();
    }

    private function hasTies($ranking)
    {
        $hasTies = false;
        $rankingCount = count($ranking);
        for ($i = 1; $i < $rankingCount; $i++) {
            if ($ranking[$i]['ranking'] === $ranking[$i - 1]['ranking']) {
                $hasTies = true;
                break;
            }
        }
        return $hasTies;
    }

    public function byEvent()
    {
        $outputYHEC = [
            'events' => [
                'wildlife_identification' => 'Wildlife Identification',
                'archery' => 'Archery',
                'orienteering' => 'Orienteering',
                'muzzleloader' => 'Muzzleloader',
                'safety_trail' => 'Safety Trail',
                'rifle' => 'Rifle',
                'shotgun' => 'Shotgun',
                'responsibility_exam' => 'Responsibility Exam',
            ],
            'event_categories' => [
                'junior' => 'Junior',
                'senior' => 'Senior',
            ],
            'event_groups' => [
                'individual' => 'Individual',
                'team' => 'Team',
            ],
            'overall_categories' => [
                'coach' => 'Coach',
                'junior' => 'Junior',
                'senior' => 'Senior',
            ],
            'overall_groups' => [
                'individual' => 'Individual',
                'team' => 'Team',
            ],
            'team_columns' => [
                'team_name' => 'Team',
                'score' => 'Score',
                'tie_breaker_1' => 'Tie 1',
                'tie_breaker_2' => 'Tie 2',
                'tie_breaker_3' => 'Tie 3',
                'tie_breaker_4' => 'Tie 4',
            ],
            'individual_columns' => [
                'team_name' => 'Team',
                'participant_name' => 'Name',
                'score' => 'Score',
                'tie_breaker_1' => 'Tie 1',
                'tie_breaker_2' => 'Tie 2',
                'tie_breaker_3' => 'Tie 3',
                'tie_breaker_4' => 'Tie 4',
            ],
        ];

        $outputRangeEvents = [
            'events' => [
                'air_pistol' => 'Air Pistol',
                // 'air_rifle' => 'Air Rifle',
                // 'small_pistol' => '.22 Small-bore Pistol',
                // 'small_rifle' => '.22 Small-bore Rifle',
                // 'muzzle_loader' => 'Muzzle Loader Target Challenge',
                // 'archery' => 'Archery – 3D & 5 Spot',
                'shotgun' => 'Shotgun – Sporting Clays',
            ],
            'event_categories' => [
                'junior' => 'Junior',
                'senior' => 'Senior',
            ],
            'event_groups' => [
                'individual' => 'Individual',
                'team' => 'Team',
            ],
            'overall_categories' => [
                'junior' => 'Junior',
                'senior' => 'Senior',
            ],
            'overall_groups' => [
                'individual' => 'Individual',
                'team' => 'Team',
            ],
            'team_columns' => [
                'team_name' => 'Team',
                'score' => 'Score',
                'tie_breaker_1' => 'X Count',
            ],
            'individual_columns' => [
                'team_name' => 'Team',
                'participant_name' => 'Name',
                'score' => 'Score',
                'tie_breaker_1' => 'X Count',
            ],
        ];

        $output = $outputRangeEvents;

        $events = [];
        foreach($output['events'] as $eventSlug => $eventName) {
            $events[$eventSlug] = Event::where('name', $eventName)->first();
        }
        
        $eventCategories = [];
        foreach($output['event_categories'] as $categorySlug => $categoryName) {
            $eventCategories[$categorySlug] = Category::where('name', $categoryName)->first();
        }
        
        $overallCategories = [];
        foreach($output['overall_categories'] as $categorySlug => $categoryName) {
            $overallCategories[$categorySlug] = Category::where('name', $categoryName)->first();
        }

        $eventResults = [];
        foreach ($events as $eventSlug => $event) {
            $eventResults[$eventSlug] = [];

            foreach ($eventCategories as $categorySlug => $category) {
                $teamRanking = TeamRanking::with('participants')
                                ->ByEventId($event->id)
                                ->ByCategoryId($category->id)
                                ->ByTop(3)->get(); //->OrderByWinner()->take(3)->get();

                $individualRanking = IndividualRanking::ByEventId($event->id)
                                    ->ByCategoryId($category->id)
                                    ->ByTop(3)->get(); //->OrderByWinner()->take(3)->get();

                $eventResults[$eventSlug][$categorySlug] = [
                    'team' => $teamRanking,
                    'individual' => $individualRanking,
                    'team_ties' => $this->hasTies($teamRanking),
                    'individual_ties' => $this->hasTies($individualRanking),
                ];
            }
        }

        $overallResults = [];
        foreach ($overallCategories as $categorySlug => $category) {
            $teamRanking = OverallTeamRanking::with('participants')
                            ->ByCategoryId($category->id)
                            ->ByTop(3)->get(); //->OrderByWinner()->take(3)->get();
            $individualRanking = OverallRanking::ByCategoryId($category->id)
                                ->ByTop(3)->get(); //->OrderByWinner()->take(3)->get();

            $overallResults[$categorySlug] = [
                'team' => $teamRanking,
                'individual' => $individualRanking,
                'team_ties' => $this->hasTies($teamRanking),
                'individual_ties' => $this->hasTies($individualRanking),
            ];
        }

        $output['event_results'] = $eventResults;
        $output['overall_results'] = $overallResults;
        return $output;
    }

}
