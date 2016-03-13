<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bug;


class TaskboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $project_id
     * @param  int $sprint_id
     * @return \Illuminate\Http\Response
     */
    public function index($project_id, $sprint_id = -1)
    {
        $users = collectionToSelect(User::orderBy('realname', 'ASC')->get(), true, 'realname');
        $projects = collectionToSelect(Project::orderBy('name', 'ASC')->get(), true, 'name');

        if ($project_id) {
            $sprints = \DB::table('mantis_project_table')
                ->select('mantis_custom_field_string_table.value')
                ->where('mantis_project_table.id', $project_id)
				->where('mantis_custom_field_string_table.field_id', 6)
                ->where('mantis_custom_field_string_table.value', '!=', '')
                ->join('mantis_bug_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
                ->join('mantis_custom_field_string_table', 'mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id')
                ->groupBy('mantis_custom_field_string_table.value')
                ->orderBy(\DB::raw('convert(mantis_custom_field_string_table.value,decimal)'))->get();
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

            $project = Project::find($project_id);
            $tickets = $project->bugs()->bySprint($sprint_id)->get();

            $toDo = $tickets->where('status', 10);
            $inProgress = $tickets->where('status', 50);
            $feedback   = $tickets->where('status', 20);
            $completed  = $tickets->where('status', 80);

        } else {
            $flash['error'] = 'Kies een project om door te gaan';
            return redirect(route('home'))->with($flash);
        }

        return view('taskboard.index', ['users' => $users, 'projects' => $projects, 'project' => $project, 'sprintId' => $sprint_id, 'toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed, 'sprints' => $sprints]);
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
            $pusher = new \Pusher(env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_APP_ID'));
            $pusher->trigger(
                'refreshChannel'.$request->get('project_id').$request->get('sprint_id').$request->get('env'),
                'changeStatus',
                [
                    'id' => $ticket->id,
                    'drop_id' => $request->get('dropId'),
                    'user' => $request->get('user'),
                    'handler' => $ticket->handler_id
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
        return redirect(route('taskboard.index', ['project_id' => $request->get('project_id'), 'sprint_id' => $request->get('sprint_id')]));
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
            $pusher = new \Pusher(env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_APP_ID'));
            $pusher->trigger(
                'refreshChannel'.$request->get('project_id').$request->get('sprint_id').$request->get('env'),
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
        return redirect(route('taskboard.index', ['project_id' => $request->get('project_id'), 'sprint_id' => $request->get('sprint_id')]));
    }
}
