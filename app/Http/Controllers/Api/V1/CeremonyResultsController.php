<?php

namespace App\Http\Controllers\Api\V1;

use App\Event;
use App\Category;
use App\TeamRanking;
use App\IndividualRanking;
use App\OverallRanking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class CeremonyResultsController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::get();
        $categories = Category::get();

        $output = [
            'groups' => ['Team', 'Individual', 'Overall'],
            'Team' => [
                'columns' => [
                    'Team Name' => 'team_name',
                    'Score' => 'score',
                    'Tie 1' => 'tie_breaker_1',
                    'Tie 2' => 'tie_breaker_2',
                    'Tie 3' => 'tie_breaker_3',
                    'Tie 4' => 'tie_breaker_4',
                ],
                'data' => [],
            ],
            'Individual' => [
                'columns' => [
                    'Name' => 'participant_name',
                    'Team' => 'team_name',
                    'Score' => 'score',
                    'Tie 1' => 'tie_breaker_1',
                    'Tie 2' => 'tie_breaker_2',
                    'Tie 3' => 'tie_breaker_3',
                    'Tie 4' => 'tie_breaker_4',
                ],
                'data' => [],
            ],
            'Overall' => [
                'columns' => [
                    'Name' => 'participant_name',
                    'Team' => 'team_name',
                    'Score' => 'score',
                    'Tie 1' => 'tie_breaker_1',
                    'Tie 2' => 'tie_breaker_2',
                    'Tie 3' => 'tie_breaker_3',
                    'Tie 4' => 'tie_breaker_4',
                ],
                'data' => [],
            ],
        ];

        foreach($events as $event) {
            $output['Team']['data'][$event->name] = [
                'id' => $event->id,
                'name' => $event->name,
                'categories' => [],
            ];
            foreach ($categories as $category) {
                $output['Team']['data'][$event->name]['categories'][$category->name] =
                [
                    'id' => $category->id,
                    'name' => $category->name,
                    'results' => TeamRanking::ByEventId($event->id)
                            ->ByCategoryId($category->id)
                            ->OrderByWinner()->take(3)->get(),
                ];
            }
        }

        foreach($events as $event) {
            $output['Individual']['data'][$event->name] = [
                'id' => $event->id,
                'name' => $event->name,
                'categories' => [],
            ];
            foreach ($categories as $category) {
                $output['Individual']['data'][$event->name]['categories'][$category->name] =
                [
                    'id' => $category->id,
                    'name' => $category->name,
                    'results' => IndividualRanking::ByEventId($event->id)
                            ->ByCategoryId($category->id)
                            ->OrderByWinner()->take(3)->get(),
                ];
            }
        }

        $output['Overall']['data']['Overall'] = [
            'id' => $event->id,
            'name' => 'Overall',
            'categories' => [],
        ];
        foreach ($categories as $category) {
            $output['Overall']['data']['Overall']['categories'][$category->name] =
            [
                'id' => $category->id,
                'name' => $category->name,
                'results' => OverallRanking::ByCategoryId($category->id)
                        ->OrderByWinner()->take(3)->get(),
            ];
        }

        return $output;
    }

}
