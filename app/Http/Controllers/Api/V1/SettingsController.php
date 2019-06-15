<?php

namespace App\Http\Controllers\Api\V1;

use App\Settings;
use App\Http\Controllers\Controller;
use App\Http\Resources\Settings as SettingsResource;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class SettingsController extends Controller
{
    public function index()
    {
        return new SettingsResource(Settings::with([])->get());
    }

    public function update(UpdateSettingsRequest $request, $id)
    {
        if (Gate::denies('settings')) {
            return abort(401);
        }

        $score = Settings::findOrFail($id);
        $score->update($request->all());
        
        return (new SettingsResource($score))
            ->response()
            ->setStatusCode(202);
    }

}
