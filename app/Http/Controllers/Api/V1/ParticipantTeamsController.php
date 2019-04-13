<?php

namespace App\Http\Controllers\Api\V1;

use App\ParticipantTeam;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParticipantTeam as ParticipantTeamResource;
use App\Http\Requests\Admin\StoreParticipantTeamsRequest;
use App\Http\Requests\Admin\UpdateParticipantTeamsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class ParticipantTeamsController extends Controller
{
    public function index()
    {
        

        return new ParticipantTeamResource(ParticipantTeam::with(['category'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('participant_team_view')) {
            return abort(401);
        }

        $participant_team = ParticipantTeam::with(['category'])->findOrFail($id);

        return new ParticipantTeamResource($participant_team);
    }

    public function store(StoreParticipantTeamsRequest $request)
    {
        if (Gate::denies('participant_team_create')) {
            return abort(401);
        }

        $participant_team = ParticipantTeam::create($request->all());
        
        

        return (new ParticipantTeamResource($participant_team))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateParticipantTeamsRequest $request, $id)
    {
        if (Gate::denies('participant_team_edit')) {
            return abort(401);
        }

        $participant_team = ParticipantTeam::findOrFail($id);
        $participant_team->update($request->all());
        
        
        

        return (new ParticipantTeamResource($participant_team))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('participant_team_delete')) {
            return abort(401);
        }

        $participant_team = ParticipantTeam::findOrFail($id);
        $participant_team->delete();

        return response(null, 204);
    }
}
