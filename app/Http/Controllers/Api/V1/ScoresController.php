<?php

namespace App\Http\Controllers\Api\V1;

use App\Score;
use App\Http\Controllers\Controller;
use App\Http\Resources\Score as ScoreResource;
use App\Http\Requests\Admin\StoreScoresRequest;
use App\Http\Requests\Admin\UpdateScoresRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class ScoresController extends Controller
{
    public function index()
    {
        

        return new ScoreResource(Score::with(['event', 'company', 'contact'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('score_view')) {
            return abort(401);
        }

        $score = Score::with(['event', 'company', 'contact'])->findOrFail($id);

        return new ScoreResource($score);
    }

    public function store(StoreScoresRequest $request)
    {
        if (Gate::denies('score_create')) {
            return abort(401);
        }

        $score = Score::create($request->all());
        
        

        return (new ScoreResource($score))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateScoresRequest $request, $id)
    {
        if (Gate::denies('score_edit')) {
            return abort(401);
        }

        $score = Score::findOrFail($id);
        $score->update($request->all());
        
        
        

        return (new ScoreResource($score))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('score_delete')) {
            return abort(401);
        }

        $score = Score::findOrFail($id);
        $score->delete();

        return response(null, 204);
    }
}
