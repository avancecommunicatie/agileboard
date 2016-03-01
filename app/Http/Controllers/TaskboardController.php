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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectId          = Input::get('project_id');
        $sprintId           = Input::get('sprint_id', 1);

        $users = collectionToSelect(User::orderBy('realname', 'DESC')->get(), false, 'realname');

        if ($projectId && $sprintId) {
            $project        = Project::with('fields.bugs')->find($projectId);
            $projectName    = $project->name;
            $sprints        = $project->fields->first()->bugs()->distinct()->lists('value')->toArray();

            $toDo       = Bug::where('project_id', $projectId)->where('status', 10)->with('user', 'bugText', 'bugnote')->get();
            $inProgress = Bug::where('project_id', $projectId)->where('status', 50)->with('user', 'bugText', 'bugnote')->get();
            $feedback   = Bug::where('project_id', $projectId)->where('status', 20)->with('user', 'bugText', 'bugnote')->get();
            $completed  = Bug::where('project_id', $projectId)->where('status', 80)->with('user', 'bugText', 'bugnote')->get();

        } else {
            return redirect(route('home'));
        }

        return view('taskboard', ['users' => $users, 'projectId' => $projectId, 'projectName' => $projectName, 'toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed, 'sprints' => $sprints]);
    }

    /**
     * Update the status of a ticket.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
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
       return;
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

        if ($ticket) {
            $ticket->handler_id = $request->get('handlerId');
            $ticket->save();
        }

        return;
    }
}
