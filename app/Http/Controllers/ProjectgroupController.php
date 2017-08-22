<?php

namespace App\Http\Controllers;

use App\Project;
use App\Projectgroup;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ProjectgroupRequest;
use App\Http\Controllers\Controller;

class ProjectgroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $projects = Project::withSprints()->get();

        return view('projectgroup.create', ['projectgroup' => $projectgroup, 'projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectgroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectgroupRequest $request)
    {
        $projectgroup = new Projectgroup();
        $projectgroup->name = $request->get('name');
        $projectgroup->save();

        $sync = [];
        if ($request->has('projects')) {
            foreach ($request->get('projects') as $id => $name) {
                $sync[] = $id;
            }
        }
        $projectgroup->projects()->sync($sync);

        return redirect(route('projectgroup.index'))->with('info', 'Agile Project opgeslagen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route('projectgroup.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectgroup = Projectgroup::with('projects')->find($id);

        if ($projectgroup) {
            $projects = Project::withSprints()->get();

            return view('projectgroup.edit', ['projectgroup' => $projectgroup, 'projects' => $projects]);
        }
        return redirect()->route('projectgroup.index')->with('error', 'Kan Agile Project niet vinden');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectgroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectgroupRequest $request, $id)
    {
        $projectgroup = Projectgroup::find($id);
        $projectgroup->name = $request->get('name');
        $projectgroup->save();

        $sync = [];
        if ($request->has('projects')) {
            foreach ($request->get('projects') as $id => $name) {
                $sync[] = $id;
            }
        }
        $projectgroup->projects()->sync($sync);

        return redirect(route('projectgroup.index'))->with('success', 'Agile Project gewijzigd');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response['success'] = false;
        $projectgroup = Projectgroup::find($id);

        if ($projectgroup) {
            $stories = $projectgroup->stories()->get();

            if ($stories && $stories->count() > 0) {
                $stories->each(function($story) {
                    $story->delete();
                });
            }

            $projectgroup->projects()->detach();
            $projectgroup->delete();
            $response['success'] = true;
        }
        return $response;
    }
}
