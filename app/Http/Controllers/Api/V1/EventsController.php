<?php

namespace App\Http\Controllers\Api\V1;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event as EventResource;
use App\Http\Requests\Admin\StoreEventsRequest;
use App\Http\Requests\Admin\UpdateEventsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class EventsController extends Controller
{
    public function index()
    {
        

        return new EventResource(Event::with([])->get());
    }

    public function show($id)
    {
        if (Gate::denies('event_view')) {
            return abort(401);
        }

        $event = Event::with([])->findOrFail($id);

        return new EventResource($event);
    }

    public function store(StoreEventsRequest $request)
    {
        if (Gate::denies('event_create')) {
            return abort(401);
        }

        $event = Event::create($request->all());
        
        

        return (new EventResource($event))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateEventsRequest $request, $id)
    {
        if (Gate::denies('event_edit')) {
            return abort(401);
        }

        $event = Event::findOrFail($id);
        $event->update($request->all());
        
        
        

        return (new EventResource($event))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('event_delete')) {
            return abort(401);
        }

        $event = Event::findOrFail($id);
        $event->delete();

        return response(null, 204);
    }
}
