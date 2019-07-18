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



class CeremonyResultsController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::get();
        $categories = Category::get();

        $output = [
            'groups' => ['Team', 'Individual', 'Overall_Team', 'Overall_Individual'],
            'Team' => [
                'name' => 'Team',
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
                'name' => 'Individual',
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
            'Overall_Team' => [
                'name' => 'Overall Team',
                'columns' => [
                    'Team' => 'team_name',
                    'Score' => 'score',
                    'Tie 1' => 'tie_breaker_1',
                    'Tie 2' => 'tie_breaker_2',
                    'Tie 3' => 'tie_breaker_3',
                    'Tie 4' => 'tie_breaker_4',
                ],
                'data' => [],
            ],
            'Overall_Individual' => [
                'name' => 'Overall Individual',
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
                    'results' => TeamRanking::with('participants')->ByEventId($event->id)
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

        $output['Overall_Team']['data']['Team'] = [
            'id' => $event->id,
            'name' => 'Overall Team',
            'categories' => [],
        ];
        foreach ($categories as $category) {
            $output['Overall_Team']['data']['Team']['categories'][$category->name] =
            [
                'id' => $category->id,
                'name' => $category->name,
                'results' => OverallTeamRanking::with('participants')->ByCategoryId($category->id)
                        ->OrderByWinner()->take(3)->get(),
            ];
        }

        $output['Overall_Individual']['data']['Individual'] = [
            'id' => $event->id,
            'name' => 'Overall Individual',
            'categories' => [],
        ];
        foreach ($categories as $category) {
            $output['Overall_Individual']['data']['Individual']['categories'][$category->name] =
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
