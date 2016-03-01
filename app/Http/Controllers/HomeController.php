<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;

class HomeController extends Controller
{
	/**
	 * The IDs of projects used by this app.
	 *
	 * @var array
	 */
	protected $projectToUse	= [227, 257, 258, 259, 260, 261, 262, 263, 264, 265, 266, 267, 270, 271];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects 			= Project::whereIn('id', $this->projectToUse)->get();
        $selectValues		= array_combine($projects->lists('id')->toArray(), $projects->lists('name')->toArray());
        $selectValues   	= [NULL => 'Kies Project...'] + $selectValues;

        return view('home', ['projects' => $projects, 'selectValues' => $selectValues]);
    }
}
