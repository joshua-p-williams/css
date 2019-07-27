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

    public function byEvent()
    {
        $output = [
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
                $eventResults[$eventSlug][$categorySlug] = [
                    'team' => TeamRanking::with('participants')
                                ->ByEventId($event->id)
                                ->ByCategoryId($category->id)
                                ->OrderByWinner()->take(3)->get(),
                    'individual' => IndividualRanking::ByEventId($event->id)
                                    ->ByCategoryId($category->id)
                                    ->OrderByWinner()->take(3)->get(),
                ];
            }
        }

        $overallResults = [];
        foreach ($overallCategories as $categorySlug => $category) {
            $overallResults[$categorySlug] = [
                'team' => OverallTeamRanking::with('participants')
                          ->ByCategoryId($category->id)
                          ->OrderByWinner()->take(3)->get(),
                'individual' => OverallRanking::ByCategoryId($category->id)
                                ->OrderByWinner()->take(3)->get(),
            ];
        }

        $output['event_results'] = $eventResults;
        $output['overall_results'] = $overallResults;
        return $output;
    }

}
