<?php

namespace App\Http\Controllers;

use App\Project;
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
        $projectId      = Input::get('project_id');
        $projectName    = Project::find($projectId)->name;
        // @todo $completed haalt alleen resultaten van vandaag op
        $today          = date(Carbon::today());

        if ($projectId) {
            $toDo = Bug::where('project_id', $projectId)->where('status', 10)->with('user')->get();
            $inProgress = Bug::where('project_id', $projectId)->where('status', 20)->with('user')->get();
            $feedback = Bug::where('project_id', $projectId)->where('status', 30)->with('user')->get();
            $completed = Bug::where('project_id', $projectId)->where('status', 40)->with('user')->with('user')->get();

        } else {
            return redirect(route('home'));
        }

        return view('taskboard', ['projectName' => $projectName, 'toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed]);
    }

    public function updateStatus(Request $request) {
        switch ($request->get('dropId')) {
            case 'todo':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->status = 10;
                $ticket->save();
            break;
            case 'inprogress':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->status = 20;
                $ticket->save();
            break;
            case 'feedback':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->status = 30;
                $ticket->save();
            break;
            case 'completed':
                $ticket = Bug::find($request->get('dragId'));
                $ticket->status = 40;
                $ticket->save();
            break;
            default:
        }
       exit;
    }
}
