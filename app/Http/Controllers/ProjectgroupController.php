<?php

namespace App\Http\Controllers;

use App\Project;
use App\Projectgroup;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('name', 'asc')->get();
        $projectgroups = Projectgroup::get();

        return view('projectgroup.index', ['projects' => $projects, 'projectgroups' => $projectgroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectgroup = new Projectgroup();
        $projects = Project::orderBy('name', 'asc')->get();

        return view('projectgroup,create', ['projectgroup' => $projectgroup, 'projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectgroup = Projectgroup::find($id);

        if ($projectgroup) {
            $projects = Project::orderBy('name', 'asc')->get();

            return view('projectgroup,edit', ['projectgroup' => $projectgroup, 'projects' => $projects]);
        }
        return redirect()->route('projectgroup.index')->with('error', 'Kon projectgroup niet vinden');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projectgroup = Projectgroup::find($id);

        if ($projectgroup) {
            $projectgroup-detach();
            $projectgroup->delete();

            return redirect()->route('projectgroup.index')->with('info', 'Projectgroep verwijderd');
        }
        return redirect()->route('projectgroup.index')->with('error', 'Kon projectgroep niet vinden');
    }
}
