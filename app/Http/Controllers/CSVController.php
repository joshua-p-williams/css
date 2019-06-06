<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ParticipantList;
use App\AllResults;

class CSVController extends Controller
{
    public function participantList() {
        $participants = ParticipantList::get(); // All users
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($participants, ['category', 'team', 'participant'])->download();
    }

    public function allResults() {
        $results = AllResults::get(); // All users
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($results, ['category_name', 'team_name', 'participant_name', 'archery', 'shotgun', 'rifle', 'muzzleloader', 'responsibility_exam', 'safety_trail', 'wildlife_id', 'orienteering'])->download();
    }
}
