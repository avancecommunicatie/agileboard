<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$projects = Project::select('mantis_project_table.*')
			->addSelect(\DB::raw('COUNT(DISTINCT(mantis_custom_field_string_table.value)) as sprints'))
			->where('mantis_custom_field_string_table.field_id', 6)
			->where('mantis_custom_field_string_table.value', '!=', '')
			->join('mantis_bug_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
			->join('mantis_custom_field_string_table', 'mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id')
			->groupBy('mantis_project_table.id')
			->orderBy('sprints', 'desc')->get();

        $selectValues		= array_combine($projects->lists('id')->toArray(), $projects->lists('name')->toArray());
        $selectValues   	= [NULL => 'Kies Project...'] + $selectValues;

        return view('home', ['projects' => $projects, 'selectValues' => $selectValues]);
    }
}
