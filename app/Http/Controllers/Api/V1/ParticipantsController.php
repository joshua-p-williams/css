<?php

namespace App\Http\Controllers\Api\V1;

use App\Participant;
use App\Http\Controllers\Controller;
use App\Http\Resources\Participant as ParticipantResource;
use App\Http\Requests\Admin\StoreParticipantsRequest;
use App\Http\Requests\Admin\UpdateParticipantsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class ParticipantsController extends Controller
{
    public function index()
    {
        

        return new ParticipantResource(Participant::with(['team', 'category'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('participant_view')) {
            return abort(401);
        }

        $participant = Participant::with(['team', 'category'])->findOrFail($id);

        return new ParticipantResource($participant);
    }

    public function store(StoreParticipantsRequest $request)
    {
        if (Gate::denies('participant_create')) {
            return abort(401);
        }

        $participant = Participant::create($request->all());
        
        

        return (new ParticipantResource($participant))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateParticipantsRequest $request, $id)
    {
        if (Gate::denies('participant_edit')) {
            return abort(401);
        }

        $participant = Participant::findOrFail($id);
        $participant->update($request->all());
        
        
        

        return (new ParticipantResource($participant))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('participant_delete')) {
            return abort(401);
        }

        $participant = Participant::findOrFail($id);
        $participant->delete();

        return response(null, 204);
    }
}
