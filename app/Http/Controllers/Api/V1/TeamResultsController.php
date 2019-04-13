<?php

namespace App\Http\Controllers\Api\V1;

use App\TeamRanking;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamRanking as TeamRankingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class TeamResultsController extends Controller
{
    public function index(Request $request)
    {
        $data = TeamRanking::with(['event', 'category', 'team'])
                ->ByEventId($request->input('eventId'))
                ->ByCategoryId($request->input('categoryId'))
                ->OrderByWinner()->get();

        return new TeamRankingResource($data);
    }
}
