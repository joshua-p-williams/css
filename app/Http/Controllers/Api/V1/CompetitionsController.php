<?php

namespace App\Http\Controllers\Api\V1;

use App\Competition;
use App\Http\Controllers\Controller;
use App\Http\Resources\Competition as CompetitionResource;
use App\Http\Requests\Admin\StoreCompetitionsRequest;
use App\Http\Requests\Admin\UpdateCompetitionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class CompetitionsController extends Controller
{
    public function index()
    {
        return new CompetitionResource(Competition::all());
    }
}
