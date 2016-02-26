<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bug;

use Input;

class DashboardController extends Controller
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
            $tickets = Bug::where('project_id', $projectId)->with('user')->get();

        } else {
            $tickets = [];
        }

        return view('dashboard', ['tickets' => $tickets]);
    }
}
