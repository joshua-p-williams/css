<?php

namespace App\Http\Controllers\Api\V1;

use App\Team;
use App\Http\Controllers\Controller;
use App\Http\Resources\Team as TeamResource;
use App\Http\Requests\Admin\StoreTeamsRequest;
use App\Http\Requests\Admin\UpdateTeamsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class TeamsController extends Controller
{
    public function index()
    {
        

        return new TeamResource(Team::with(['category'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('team_view')) {
            return abort(401);
        }

        $team = Team::with(['category'])->findOrFail($id);

        return new TeamResource($team);
    }

    public function store(StoreTeamsRequest $request)
    {
        if (Gate::denies('team_create')) {
            return abort(401);
        }

        $team = Team::create($request->all());
        
        

        return (new TeamResource($team))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTeamsRequest $request, $id)
    {
        if (Gate::denies('team_edit')) {
            return abort(401);
        }

        $team = Team::findOrFail($id);
        $team->update($request->all());
        
        
        

        return (new TeamResource($team))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('team_delete')) {
            return abort(401);
        }

        $team = Team::findOrFail($id);
        $team->delete();

        return response(null, 204);
    }
}
