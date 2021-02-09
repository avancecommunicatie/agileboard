<?php

namespace App\Http\Controllers;

use App\Bug;
use App\Checkbox;
use App\Projectgroup;
use App\Story;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoryboardRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StoryboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  $projectgroup_id
     * @param  $sprint_id
     * @return \Illuminate\Http\Response
     */
    public function index($projectgroup_id = false, $sprint_id = -1)
    {
        if ($projectgroup_id) {
            $projectgroups = collectionToSelect(Projectgroup::orderBy('name', 'ASC')->get(), false, 'name');

            $projectgroup = Projectgroup::with('projects')->find($projectgroup_id);
            $stories = Story::where('project_id', $projectgroup_id)->orderBy('created_at', 'DESC')->get();
            
            $sprints = DB::table('agile_projectgroups')
                ->select('mantis_custom_field_string_table.value')
                ->where('agile_projectgroups.id', $projectgroup_id)
                ->where('mantis_custom_field_string_table.field_id', 6)
                ->where('mantis_custom_field_string_table.value', '!=', '')
                ->join('agile_projectgroups_projects', 'agile_projectgroups.id', '=', 'agile_projectgroups_projects.projectgroup_id')
                ->join('mantis_project_table', 'mantis_project_table.id', '=', 'agile_projectgroups_projects.project_id')
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
                return redirect(route('home'))->with('error', 'Dit project heeft geen sprints');
            }

            $tickets = Bug::onSprint($projectgroup_id, $sprint_id)->where('mantis_bug_table.status', 80)->get();
            $checkboxes = Checkbox::enabled()->get();

            return view('storyboard.index', ['tickets' => $tickets,
                'stories' => $stories,
                'users' => [],
                'projectgroups' => $projectgroups,
                'projectgroup' => $projectgroup,
                'sprintId' => $sprint_id,
                'sprints' => $sprints,
                'checkboxes' => $checkboxes]);
        }
        return redirect(route('home'))->with('error', 'Kies een project');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoryboardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoryboardRequest $request)
    {
        $projectgroup = Projectgroup::find($request->get('projectgroup_id'));

        $story = new Story($request->all());
        $story->project_id = $projectgroup->id;
        $story->save();

        return redirect(route('storyboard.index', ['projectgroup_id' => $projectgroup->id]))->with('info', 'Bericht geplaatst');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $story = Story::find($id);

        if ($story) {
            $story->delete();

            return redirect()->back()->with('info', 'Story verwijderd');
        }
        return redirect()->back()->with('error', 'Kan Story niet verwijderen');
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
