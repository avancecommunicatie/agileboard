<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bug;

use Input;

class TaskboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $project_id
     * @param  int $sprint_id
     * @return \Illuminate\Http\Response
     */
    public function index($project_id, $sprint_id = 0)
    {
        $users = collectionToSelect(User::orderBy('realname', 'DESC')->get(), false, 'realname');

        if ($project_id) {
            $project        = Project::with('fields.bugs')->find($project_id);
            $projectName    = $project->name;

            if ($sprint_id == 0) {
                $sprint_id = $project->fields->first()->bugs()->orderBy('value', 'desc')->pluck('value');
            }

            $tickets    = $project->fields->where('id', 6)->first()->bugs()->where('value', $sprint_id)->with('user', 'bugText', 'bugnote')->get();
            $sprints    = $project->fields->first()->bugs()->distinct()->lists('value')->toArray();

            $toDo       = $tickets->where('status', 10);
            $inProgress = $tickets->where('status', 50);
            $feedback   = $tickets->where('status', 20);
            $completed  = $tickets->where('status', 80);

        } else {
            $flash['error'] = 'Kies een project om door te gaan';
            return redirect(route('home'))->with($flash);
        }

        return view('taskboard', ['users' => $users, 'projectId' => $project_id, 'sprintId' => $sprint_id, 'projectName' => $projectName, 'toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed, 'sprints' => array_combine($sprints, $sprints)]);
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
                $ticket->handler_id = $request->get('handlerId');
                $ticket->status = 10;
                $ticket->save();
            break;
            case 'inprogress':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->handler_id = $request->get('handlerId');
                $ticket->status = 50;
                $ticket->save();
            break;
            case 'feedback':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->handler_id = $request->get('handlerId');
                $ticket->status = 20;
                $ticket->save();
            break;
            case 'completed':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->handler_id = $request->get('handlerId');
                $ticket->status = 80;
                $ticket->save();
            break;
            default:
        }
        if ($ticket) {
            $response['success'] = true;
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
        }

        return $response;
    }
}
