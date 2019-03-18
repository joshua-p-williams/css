<?php

namespace App\Http\Controllers\Api\V1;

use App\ContactCompany;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCompany as ContactCompanyResource;
use App\Http\Requests\Admin\StoreContactCompaniesRequest;
use App\Http\Requests\Admin\UpdateContactCompaniesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class ContactCompaniesController extends Controller
{
    public function index()
    {
        

        return new ContactCompanyResource(ContactCompany::with(['category'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('contact_company_view')) {
            return abort(401);
        }

        $contact_company = ContactCompany::with(['category'])->findOrFail($id);

        return new ContactCompanyResource($contact_company);
    }

    public function store(StoreContactCompaniesRequest $request)
    {
        if (Gate::denies('contact_company_create')) {
            return abort(401);
        }

        $contact_company = ContactCompany::create($request->all());
        
        

        return (new ContactCompanyResource($contact_company))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateContactCompaniesRequest $request, $id)
    {
        if (Gate::denies('contact_company_edit')) {
            return abort(401);
        }

        $contact_company = ContactCompany::findOrFail($id);
        $contact_company->update($request->all());
        
        
        

        return (new ContactCompanyResource($contact_company))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('contact_company_delete')) {
            return abort(401);
        }

        $contact_company = ContactCompany::findOrFail($id);
        $contact_company->delete();

        return response(null, 204);
    }
}
