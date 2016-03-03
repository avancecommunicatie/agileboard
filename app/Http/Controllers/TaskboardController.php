<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Carbon\Carbon;
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

        if ($project_id) {
            $project        = Project::with('bugs')->find($project_id);
            $projectName    = $project->name;
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

            $fields = $project->fields()->where('id', 6)->first();

            if ($fields && $fields->count() > 0) {
                $bugs = $fields->bugs()->where('value', $sprint_id)->with('user', 'bugText', 'bugnote')->get();
                if ($bugs && $bugs->count() > 0) {
                    $tickets = $bugs;
                } else {
                    return redirect(route('home'))->with('info', 'Dit project heeft geen sprints');
                }
            } else {
                return redirect(route('home'))->with('info', 'Dit project heeft geen sprints');
            }

            $toDo       = [];//$tickets->where('status', 10);
            $inProgress = [];//$tickets->where('status', 50);
            $feedback   = [];//$tickets->where('status', 20);
            $completed  = [];//$tickets->where('status', 80);

            foreach ($tickets as $ticket) {
                switch ($ticket->status) {
                    case 10:
                        $toDo[] = $ticket;
                        break;
                    case 50:
                        $inProgress[] = $ticket;
                        break;
                    case 20:
                        $feedback[] = $ticket;
                        break;
                    case 80:
                        $completed[] = $ticket;
                        break;
                }
            }

        } else {
            $flash['error'] = 'Kies een project om door te gaan';
            return redirect(route('home'))->with($flash);
        }

        return view('taskboard', ['users' => $users, 'projectId' => $project_id, 'sprintId' => $sprint_id, 'projectName' => $projectName, 'toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed, 'sprints' => $sprints]);
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
     * Add a ticket to the to-do list.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeSprint(Request $request)
    {
        $projectId = $request->get('project_id');

        return redirect(route('taskboard.index', ['project_id' => $projectId, 'sprint_id' => $request->get('sprint_id')]));
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
}
