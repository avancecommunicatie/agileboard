<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Projectgroup;

use DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectgroups = Projectgroup::select('agile_projectgroups.*')
                                        ->join('agile_projectgroups_projects', 'agile_projectgroups.id', '=', 'agile_projectgroups_projects.projectgroup_id')
                                        ->join('mantis_project_table', 'mantis_project_table.id', '=', 'agile_projectgroups_projects.project_id')
                                        ->join('mantis_bug_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
                                        ->join('mantis_custom_field_string_table', 'mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id')
                                        ->addSelect(DB::raw('COUNT(DISTINCT(mantis_custom_field_string_table.value)) as sprints'))
                                        ->where('mantis_custom_field_string_table.field_id', 6)
                                        ->where('mantis_custom_field_string_table.value', '!=', '')
                                        ->groupBy('agile_projectgroups.id')
                                        ->orderBy('sprints', 'desc')
                                        ->get();

        return view('home', ['projectgroups' => $projectgroups]);
    }
}
