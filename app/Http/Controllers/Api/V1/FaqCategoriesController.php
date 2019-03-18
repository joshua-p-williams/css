<?php

namespace App\Http\Controllers\Api\V1;

use App\FaqCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCategory as FaqCategoryResource;
use App\Http\Requests\Admin\StoreFaqCategoriesRequest;
use App\Http\Requests\Admin\UpdateFaqCategoriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class FaqCategoriesController extends Controller
{
    public function index()
    {
        

        return new FaqCategoryResource(FaqCategory::with([])->get());
    }

    public function show($id)
    {
        if (Gate::denies('faq_category_view')) {
            return abort(401);
        }

        $faq_category = FaqCategory::with([])->findOrFail($id);

        return new FaqCategoryResource($faq_category);
    }

    public function store(StoreFaqCategoriesRequest $request)
    {
        if (Gate::denies('faq_category_create')) {
            return abort(401);
        }

        $faq_category = FaqCategory::create($request->all());
        
        

        return (new FaqCategoryResource($faq_category))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateFaqCategoriesRequest $request, $id)
    {
        if (Gate::denies('faq_category_edit')) {
            return abort(401);
        }

        $faq_category = FaqCategory::findOrFail($id);
        $faq_category->update($request->all());
        
        
        

        return (new FaqCategoryResource($faq_category))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('faq_category_delete')) {
            return abort(401);
        }

        $faq_category = FaqCategory::findOrFail($id);
        $faq_category->delete();

        return response(null, 204);
    }
}
