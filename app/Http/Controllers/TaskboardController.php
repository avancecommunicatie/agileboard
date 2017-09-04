<?php

namespace App\Http\Controllers;

use App\Projectgroup;
use App\MantisUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bug;

use DB;

class TaskboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $projectgroup_id
     * @param  int $sprint_id
     * @return \Illuminate\Http\Response
     */
    public function index($projectgroup_id, $sprint_id = -1)
    {
        $users = collectionToSelect(MantisUser::orderBy('realname', 'ASC')->get(), true, 'realname');
        $projectgroups = collectionToSelect(Projectgroup::orderBy('name', 'ASC')->get(), false, 'name');

        if ($projectgroup_id) {
            $projectgroup = Projectgroup::with('projects')->find($projectgroup_id);

            list($sprints, $sprint_id) = $this->getSprints($projectgroup_id, $sprint_id);

            $tickets = Bug::with('fields')->onSprint($projectgroup_id, $sprint_id)->get();

            list($toDo, $inProgress, $feedback, $completed) = $this->categorizeTickets($tickets);

        } else {
            $flash['error'] = 'Kies een project om door te gaan';
            return redirect(route('home'))->with($flash);
        }

        return view('taskboard.index', ['users' => $users, 'projectgroups' => $projectgroups, 'projectgroup' => $projectgroup, 'sprintId' => $sprint_id, 'toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed, 'sprints' => $sprints]);
    }

    public function sprintless($projectgroup_id)
    {
        $sprint_id = -1;
        $users = collectionToSelect(MantisUser::orderBy('realname', 'ASC')->get(), true, 'realname');
        $projectgroups = collectionToSelect(Projectgroup::orderBy('name', 'ASC')->get(), false, 'name');

        if ($projectgroup_id) {
            $projectgroup = Projectgroup::with('projects')->find($projectgroup_id);

            list($sprints, $sprint_id) = $this->getSprints($projectgroup_id, $sprint_id);
            $sprint_id = 'sprintless';

            $tickets = Bug::with('fields')->sprintless($projectgroup_id)->get();

            list($toDo, $inProgress, $feedback, $completed) = $this->categorizeTickets($tickets);

        } else {
            $flash['error'] = 'Kies een project om door te gaan';
            return redirect(route('home'))->with($flash);
        }

        return view('taskboard.index', ['users' => $users, 'projectgroups' => $projectgroups, 'projectgroup' => $projectgroup, 'sprintId' => $sprint_id, 'toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed, 'sprints' => $sprints]);
    }

    /**
     * Update the status of a ticket.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $response['success'] = false;
        $ticket = false;

        switch ($request->get('dropId')) {
            case 'todo':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->handler_id = 0;
                $ticket->status = 10;
                $ticket->save();
                break;
            case 'inprogress':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->status = 50;
                $ticket->save();
                break;
            case 'feedback':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->status = 20;
                $ticket->save();
                break;
            case 'completed':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->status = 80;
                $ticket->save();
                break;
            default:
        }
        if ($ticket) {
            $response['success'] = true;
            $options = array(
                'cluster' => 'eu',
                'encrypted' => true
            );
            $pusher = new \Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                $options
            );
            $pusher->trigger(
                'refreshChannel'.$request->get('projectgroup_id').$request->get('sprint_id').$request->get('env'),
                'changeStatus',
                [
                    'id' => $ticket->id,
                    'drop_id' => $request->get('dropId'),
                    'user' => $request->get('user'),
                    'handler' => $ticket->handler_id,
                    'src_id' => $request->get('srcId')
                ]
            );
        }

        return $response;
    }

    /**
     * Change the current sprint.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeSprint(Request $request)
    {
        return redirect(route('taskboard.index', ['projectgroup_id' => $request->get('projectgroup_id'), 'sprint_id' => $request->get('sprint_id')]));
    }

    /**
     * Change the ticket's current handler.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeHandler(Request $request)
    {
        $ticket = Bug::find($request->get('ticketId'));
        $response['success'] = false;

        if ($ticket) {
            $ticket->handler_id = $request->get('handlerId');
            $ticket->save();
            $response['success'] = true;
            $options = array(
                'cluster' => 'eu',
                'encrypted' => true
            );
            $pusher = new \Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                $options
            );
            $pusher->trigger(
                'refreshChannel'.$request->get('projectgroup_id').$request->get('sprint_id').$request->get('env'),
                'changeHandler',
                [
                    'id' => $ticket->id,
                    'handler' => $ticket->handler_id,
                    'handlerName' => ($ticket->user ? $ticket->user->realname : 'niemand')
                ]
            );
        }

        return $response;
    }
    /**
     * Change the current project.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeProject(Request $request)
    {
        return redirect(route('taskboard.index', ['projectgroup_id' => $request->get('projectgroup_id'), 'sprint_id' => $request->get('sprint_id')]));
    }

    protected function getSprints($projectgroup_id, $sprint_id)
    {
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
        $sprints['sprintless'] = 'Punten zonder sprint';

        return [$sprints, $sprint_id];
    }

    protected function categorizeTickets($tickets)
    {
        $toDo = $tickets->where('status', 10, false);
        if ($toDo) {
            $toDo->total_hours = 0;
            $toDo->each(function($ticket) use ($toDo) {
                if ($ticket->fields->where('id', 1, false)->first()) {
                    $toDo->total_hours += $ticket->fields->where('id', 1, false)->first()->pivot->value;
                }
            });
        }

        $inProgress = $tickets->where('status', 50, false);
        if ($inProgress) {
            $inProgress->total_hours = 0;
            $inProgress->each(function($ticket) use ($inProgress) {
                if ($ticket->fields->where('id', 1, false)->first()) {
                    $inProgress->total_hours += $ticket->fields->where('id', 1, false)->first()->pivot->value;
                }
            });
        }

        $feedback   = $tickets->where('status', 20, false);
        if ($feedback) {
            $feedback->total_hours = 0;
            $feedback->each(function($ticket) use ($feedback) {
                if ($ticket->fields->where('id', 1, false)->first()) {
                    $feedback->total_hours += $ticket->fields->where('id', 1, false)->first()->pivot->value;
                }
            });
        }

        $completed  = $tickets->where('status', 80, false);
        if ($completed) {
            $completed->total_hours = 0;
            $completed->each(function($ticket) use ($completed) {
                if ($ticket->fields->where('id', 1, false)->first()) {
                    $completed->total_hours += $ticket->fields->where('id', 1, false)->first()->pivot->value;
                }
            });
        }

        return [$toDo, $inProgress, $feedback, $completed];
    }
}
