<?php

namespace App\Http\Controllers\Api\V1;

use App\CategoryCompletion;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCompletion as CategoryCompletionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class CategoryCompletionsController extends Controller
{
    public function index()
    {
        

        return new CategoryCompletionResource(CategoryCompletion::with(['event', 'category'])->HasParticipants()->get());
    }
}
