<?php

namespace App\Http\Controllers\Api\V1;

use App\FaqQuestion;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqQuestion as FaqQuestionResource;
use App\Http\Requests\Admin\StoreFaqQuestionsRequest;
use App\Http\Requests\Admin\UpdateFaqQuestionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class FaqQuestionsController extends Controller
{
    public function index()
    {
        

        return new FaqQuestionResource(FaqQuestion::with(['category'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('faq_question_view')) {
            return abort(401);
        }

        $faq_question = FaqQuestion::with(['category'])->findOrFail($id);

        return new FaqQuestionResource($faq_question);
    }

    public function store(StoreFaqQuestionsRequest $request)
    {
        if (Gate::denies('faq_question_create')) {
            return abort(401);
        }

        $faq_question = FaqQuestion::create($request->all());
        
        

        return (new FaqQuestionResource($faq_question))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateFaqQuestionsRequest $request, $id)
    {
        if (Gate::denies('faq_question_edit')) {
            return abort(401);
        }

        $faq_question = FaqQuestion::findOrFail($id);
        $faq_question->update($request->all());
        
        
        

        return (new FaqQuestionResource($faq_question))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('faq_question_delete')) {
            return abort(401);
        }

        $faq_question = FaqQuestion::findOrFail($id);
        $faq_question->delete();

        return response(null, 204);
    }
}
