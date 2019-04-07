<?php

namespace App\Http\Controllers\Api\V1;

use App\TeamCompletion;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCompletion as TeamCompletionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class TeamCompletionsController extends Controller
{
    public function index()
    {
        return new TeamCompletionResource(TeamCompletion::with(['event', 'category', 'company'])->HasParticipants()->get());
    }
}
