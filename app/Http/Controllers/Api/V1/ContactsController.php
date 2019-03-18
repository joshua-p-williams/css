<?php

namespace App\Http\Controllers\Api\V1;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact as ContactResource;
use App\Http\Requests\Admin\StoreContactsRequest;
use App\Http\Requests\Admin\UpdateContactsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class ContactsController extends Controller
{
    public function index()
    {
        

        return new ContactResource(Contact::with(['company', 'category'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('contact_view')) {
            return abort(401);
        }

        $contact = Contact::with(['company', 'category'])->findOrFail($id);

        return new ContactResource($contact);
    }

    public function store(StoreContactsRequest $request)
    {
        if (Gate::denies('contact_create')) {
            return abort(401);
        }

        $contact = Contact::create($request->all());
        
        

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateContactsRequest $request, $id)
    {
        if (Gate::denies('contact_edit')) {
            return abort(401);
        }

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        
        
        

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('contact_delete')) {
            return abort(401);
        }

        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response(null, 204);
    }
}
