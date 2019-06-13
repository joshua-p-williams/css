<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ParticipantList;
use App\IndividualRanking;

class CSVController extends Controller
{
    public function participantList() {
        $participants = ParticipantList::get(); // All users
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($participants, ['category', 'team', 'participant'])->download();
    }

    public function resultsSummary() {
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
    
    public function teamResults() {
        $results = [];
        $resultsSummary = $this->resultsSummary();

        $categories = $resultsSummary['results']->groupBy(['Category', 'Team']);
        foreach($categories as $category => $teams) {
            foreach($teams as $team => $scores) {
                $summary = [
                    'Category' => $category,
                    'Team' => $team,
                    'Total Score' => $scores->sum('Total Score'),
                    'Tie Breaker 1' => $scores->sum('Tie Breaker 1'),
                    'Tie Breaker 2' => $scores->sum('Tie Breaker 2'),
                    'Tie Breaker 3' => $scores->sum('Tie Breaker 3'),
                    'Tie Breaker 4' => $scores->sum('Tie Breaker 4'),
                ];

                foreach($resultsSummary['events'] as $event) {
                    $summary[$event] = $scores->sum($event);
                }

                $results[] = $summary;
            }
        }

        $fields = array_merge(['Category', 'Team', 'Total Score', 'Tie Breaker 1', 'Tie Breaker 2', 'Tie Breaker 3', 'Tie Breaker 4'], $resultsSummary['events']);

        $csvExporter = new \Laracsv\Export();
        $csvExporter->build(collect($results), $fields)->download();
    }

    public function individualResults() {
        $summary = $this->resultsSummary();
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($summary['results'], $summary['fields'])->download();
    }
}
