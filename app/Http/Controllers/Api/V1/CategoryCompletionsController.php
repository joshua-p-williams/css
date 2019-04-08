<?php

namespace App\Http\Controllers\Api\V1;

use App\CategoryCompletion;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCompletion as CategoryCompletionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class CategoryCompletionsController extends Controller
{
    public function index(Request $request)
    {
        $data = CategoryCompletion::with(['event', 'category'])
                ->ByEventId($request->input('eventId'))
                ->ByCategoryId($request->input('categoryId'))
                ->HasParticipants()->Unfinished()->get();

        return new CategoryCompletionResource($data);
    }
}
