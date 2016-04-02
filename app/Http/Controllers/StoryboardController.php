<?php

namespace App\Http\Controllers;

use App\Bug;
use App\Projectgroup;
use App\Story;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StoryboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  $project_id
     * @param  $sprint_id
     * @return \Illuminate\Http\Response
     */
    public function index($projectgroup_id = false, $sprint_id = -1)
    {
        if ($projectgroup_id) {
            $projectgroups = collectionToSelect(Projectgroup::orderBy('name', 'ASC')->get(), false, 'name');

            $projectgroup = Projectgroup::with('projects')->find($projectgroup_id);
            $stories = Story::where('projectgroup_id', $projectgroup_id)->orderBy('created_at', 'DESC')->get();
            
            $sprints = DB::table('lg_agile.projectgroups')
                ->select('mantis_custom_field_string_table.value')
                ->where('projectgroups.id', $projectgroup_id)
                ->where('mantis_custom_field_string_table.field_id', 6)
                ->where('mantis_custom_field_string_table.value', '!=', '')
                ->join('lg_agile.projectgroups_projects', 'projectgroups.id', '=', 'projectgroups_projects.projectgroup_id')
                ->join('mantis_project_table', 'mantis_project_table.id', '=', 'projectgroups_projects.project_id')
                ->join('mantis_bug_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
                ->join('mantis_custom_field_string_table', 'mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id')
                ->groupBy('mantis_custom_field_string_table.value')
                ->orderBy(\DB::raw('convert(mantis_custom_field_string_table.value,decimal)'))
                ->get();

            $sprintsObj = array_reverse($sprints);
            if ($sprint_id == -1) {
                if (!empty($sprintsObj) ) {
                    $sprint_id = $sprintsObj[0]->value;
                }
            }

            $sprints = [];
            foreach($sprintsObj as $s){
                $sprints[$s->value] = $s->value;
            }

            if (count($sprints) == 0) {
                return redirect(route('home'))->with('info', 'Dit project heeft geen sprints');
            }

            $tickets = Bug::onSprint($projectgroup_id, $sprint_id)->where('mantis_bug_table.status', 50)->get();

            return view('storyboard.index', ['tickets' => $tickets,
                'stories' => $stories,
                'users' => [],
                'projectgroups' => $projectgroups,
                'projectgroup' => $projectgroup,
                'sprintId' => $sprint_id,
                'sprints' => $sprints]);
        }
        return redirect(route('home'))->with('error', 'Kies een project');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $projectgroup = Projectgroup::find($request->get('projectgroup_id'));

        $story = new Story($request->all());
        $story->save();

        return redirect(route('storyboard.index', ['projectgroup_id' => $projectgroup->id]));
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
        //
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
        //
    }

    /**
     * Change the current project.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeProject(Request $request)
    {
        return redirect(route('storyboard.index', ['project_id' => $request->get('projectgroup_id'), 'sprint_id' => $request->get('sprint_id')]));
    }

    /**
     * Change the current sprint.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeSprint(Request $request)
    {
        return redirect(route('storyboard.index', ['project_id' => $request->get('projectgroup_id'), 'sprint_id' => $request->get('sprint_id')]));
    }
}
