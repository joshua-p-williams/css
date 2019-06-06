<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ParticipantList;

class CSVController extends Controller
{
    public function participantList() {
        $participants = ParticipantList::get(); // All users
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($participants, ['category', 'team', 'participant'])->download();
    }
}
