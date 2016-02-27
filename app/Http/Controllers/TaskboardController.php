<?php

namespace App\Http\Controllers;

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
        $projectId = Input::get('project_id');

        if ($projectId) {
            $toDo = Bug::where('project_id', $projectId)->where('status', 10)->with('user')->get();
            $inProgress = Bug::where('project_id', $projectId)->where('status', 20)->with('user')->get();
            $feedback = Bug::where('project_id', $projectId)->where('status', 30)->with('user')->get();
            $completed = Bug::where('project_id', $projectId)->where('status', 40)->with('user')->where('last_updated', Carbon::today())->with('user')->get();

        } else {
            return redirect(route('home'));
        }

        return view('taskboard', ['toDo' => $toDo, 'inProgress' => $inProgress, 'feedback' => $feedback, 'completed' => $completed]);
    }

    public function updateStatus(Request $request) {
        dd($request->all());

        switch ($request->all()) {
            case 'todo':

            break;
            case 'inprogress':

            break;
            case 'feedback':

            break;
            case 'completed':

            break;
            default:
                
        }


       exit;
    }
}
