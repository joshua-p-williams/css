<?php

namespace App\Http\Controllers\Api\V1;

use App\IndividualRanking;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndividualRanking as IndividualRankingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class IndividualResultsController extends Controller
{
    public function index(Request $request)
    {
        $data = IndividualRanking::with(['event', 'category', 'team', 'participant'])
                ->ByEventId($request->input('eventId'))
                ->ByCategoryId($request->input('categoryId'))
                ->OrderByWinner()->get();

        return new IndividualRankingResource($data);
    }
}
