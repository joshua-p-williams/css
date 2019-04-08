<?php

namespace App\Http\Controllers\Api\V1;

use App\IndividualRanking;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndividualRanking as IndividualRankingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class IndividualCompletionsController extends Controller
{
    public function index(Request $request)
    {
        $data = IndividualRanking::with(['event', 'category', 'company', 'contact'])
                ->ByEventId($request->input('eventId'))
                ->ByCategoryId($request->input('categoryId'))
                ->UnScored()->get();

        return new IndividualRankingResource($data);
    }
}
