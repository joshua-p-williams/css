<?php

namespace App\Http\Controllers\Admin;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamsRequest;
use App\Http\Requests\Admin\UpdateTeamsRequest;

class TeamsController extends Controller
{
    /**
     * Display a listing of Team.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {if ($_GATES_$) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('team_delete')) {
                return abort(401);
            }
            $teams = Team::onlyTrashed()->get();
        } else {
            $teams = Team::all();
        }

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating new Team.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {if ($_GATES_$) {
            return abort(401);
        }
        
        $categories = \App\Category::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.teams.create', compact('categories'));
    }

    /**
     * Store a newly created Team in storage.
     *
     * @param  \App\Http\Requests\StoreTeamsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamsRequest $request)
    {if ($_GATES_$) {
            return abort(401);
        }
        $team = Team::create($request->all());



        return redirect()->route('admin.teams.index');
    }


    /**
     * Show the form for editing Team.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {if ($_GATES_$) {
            return abort(401);
        }
        
        $categories = \App\Category::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $team = Team::findOrFail($id);

        return view('admin.teams.edit', compact('team', 'categories'));
    }

    /**
     * Update Team in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamsRequest $request, $id)
    {if ($_GATES_$) {
            return abort(401);
        }
        $team = Team::findOrFail($id);
        $team->update($request->all());



        return redirect()->route('admin.teams.index');
    }


    /**
     * Display Team.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {if ($_GATES_$) {
            return abort(401);
        }
        $team = Team::findOrFail($id);

        return view('admin.teams.show', compact('team'));
    }


    /**
     * Remove Team from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {if ($_GATES_$) {
            return abort(401);
        }
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect()->route('admin.teams.index');
    }

    /**
     * Delete all selected Team at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {if ($_GATES_$) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Team::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Team from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {if ($_GATES_$) {
            return abort(401);
        }
        $team = Team::onlyTrashed()->findOrFail($id);
        $team->restore();

        return redirect()->route('admin.teams.index');
    }

    /**
     * Permanently delete Team from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {if ($_GATES_$) {
            return abort(401);
        }
        $team = Team::onlyTrashed()->findOrFail($id);
        $team->forceDelete();

        return redirect()->route('admin.teams.index');
    }
}
