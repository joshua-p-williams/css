<?php

namespace App\Http\Controllers\Api\V1;

use App\OverallRanking;
use App\Http\Controllers\Controller;
use App\Http\Resources\OverallRanking as OverallRankingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class OverallResultsController extends Controller
{
    public function index(Request $request)
    {
        $data = OverallRanking::with(['event', 'category', 'team', 'participant'])
                ->ByEventId($request->input('eventId'))
                ->ByCategoryId($request->input('categoryId'))
                ->ByTop(10000)->get(); // ->OrderByWinner()->get();

        return new OverallRankingResource($data);
    }
}
