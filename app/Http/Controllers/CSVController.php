<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ParticipantList;
use App\IndividualRanking;
use App\TeamRanking;

class CSVController extends Controller
{
    public function participantList() {
        $participants = ParticipantList::get(); // All users
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($participants, ['category', 'team', 'participant'])->download();
    }

    public function individualRankingSummary() {
        $results = [];
        $fields = [];
        $events = [];

        $categories = IndividualRanking::get()->groupBy(['category_name', 'team_name', 'participant_name']);

        foreach($categories as $category => $teams) {
            foreach($teams as $team => $participants) {
                foreach($participants as $participant => $scores) {

                    $summary = [
                        'Category' => $category,
                        'Team' => $team,
                        'Participant' => $participant,
                        'Total Score' => $scores->sum('score'),
                        'Tie Breaker 1' => $scores->max('tie_breaker_1'),
                        'Tie Breaker 2' => $scores->max('tie_breaker_2'),
                        'Tie Breaker 3' => $scores->max('tie_breaker_3'),
                        'Tie Breaker 4' => $scores->max('tie_breaker_4'),
                    ];

                    $eventScores = $scores->groupBy('event_name');

                    if (empty($fields)) {
                        $events = $eventScores->keys()->toArray();
                        $fields = array_merge(array_keys($summary), $events);
                    }

                    foreach($eventScores as $event => $eventScores) {
                        $summary[$event] = $eventScores->sum('score');
                    }

                    $results[] = $summary;

                }
            }
        }

        return [
            'results' => collect($results),
            'fields' => $fields,
            'events' => $events,
        ];
    }

    public function individualResults() {
        $summary = $this->individualRankingSummary();
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($summary['results'], $summary['fields'])->download();
    }
    

    public function teamRankingSummary() {
        $results = [];
        $fields = [];
        $events = [];

        $categories = TeamRanking::get()->groupBy(['category_name', 'team_name']);

        foreach($categories as $category => $teams) {
            foreach($teams as $team => $scores) {
                $summary = [
                    'Category' => $category,
                    'Team' => $team,
                    'Total Score' => $scores->sum('score'),
                    'Tie Breaker 1' => $scores->max('tie_breaker_1'),
                    'Tie Breaker 2' => $scores->max('tie_breaker_2'),
                    'Tie Breaker 3' => $scores->max('tie_breaker_3'),
                    'Tie Breaker 4' => $scores->max('tie_breaker_4'),
                ];

                $eventScores = $scores->groupBy('event_name');

                if (empty($fields)) {
                    $events = $eventScores->keys()->toArray();
                    $fields = array_merge(array_keys($summary), $events);
                }

                foreach($eventScores as $event => $eventScores) {
                    $summary[$event] = $eventScores->sum('score');
                }

                $results[] = $summary;
            }
        }

        return [
            'results' => collect($results),
            'fields' => $fields,
            'events' => $events,
        ];
    }

    public function teamResults() {
        $summary = $this->teamRankingSummary();
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($summary['results'], $summary['fields'])->download();
    }
}
