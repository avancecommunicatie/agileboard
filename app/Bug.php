<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
	protected $table 	= 'mantis_bug_table';
	protected $fillable = ['project_id', 'reporter_id', 'handler_id', 'duplicate_id', 'priority', 'severity', 'reproducibility', 'status', 'resolution', 'projection', 'eta',
							'bug_text_id', 'os', 'os_build', 'platform', 'version', 'fixed_in_version', 'build', 'profile_id', 'view_state', 'summary', 'sponsorship_total',
							'sticky', 'target_version', 'category_id', 'date_submitted', 'due_date', 'last_updated'];
	public $timestamps 	= false;

	public function user() {
		return $this->belongsTo('App\MantisUser', 'handler_id');
	}

	public function bugText() {
		return $this->belongsTo('App\BugText');
	}

	public function bugnote() {
		return $this->hasMany('App\Bugnote');
	}

	public function project() {
		return $this->belongsTo('App\Project');
	}

	public function category() {
		return $this->belongsTo('App\Category');
	}

	public function fields() {
		return $this->belongsToMany('App\CustomField', 'mantis_custom_field_string_table', 'bug_id', 'field_id')->withPivot('value');
	}

    public function checkboxes() {
        return $this->belongsToMany('App\Checkbox', 'agile_bug_checkbox', 'bug_id', 'checkbox_id');
    }

	public function scopeBugnoteCount($query)
    {
        $query->leftJoin('mantis_bugnote_table', 'mantis_bugnote_table.bug_id', '=', 'mantis_bug_table.id')
            ->addSelect(\DB::raw('count(mantis_bugnote_table.id) as bugnotecounter'))
            ->groupBy('mantis_bug_table.id');
    }

//	public function scopeSprintless($query, $projectgroup_id)
//    {
//        $query
//            ->select('mantis_bug_table.*')
//            ->leftJoin('mantis_custom_field_string_table', function($join) {
//                $join->on('mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id');
//                $join->on(\DB::raw('mantis_custom_field_string_table.field_id = 6'), \DB::raw(''), \DB::raw(''));
//            })
//            ->join('mantis_project_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
//            ->join('agile_projectgroups_projects', 'mantis_project_table.id', '=', 'agile_projectgroups_projects.project_id')
//            ->join('agile_projectgroups', 'agile_projectgroups.id', '=', 'agile_projectgroups_projects.projectgroup_id')
//            ->addSelect('mantis_bug_table.status')
//            ->where('agile_projectgroups.id', $projectgroup_id)
//            ->where(function ($query) {
//                $query->where('mantis_custom_field_string_table.value', '');
//                $query->orWhereNull('mantis_custom_field_string_table.value');
//            });
//    }

	/**
	 * Scope for getting tickets grouped by projectgroup and sprint.
	 * 
	 * @param $query
	 * @param $projectgroup_id
	 * @param $sprint_id
	 */
    public function scopeOnSprint($query, $projectgroup_id, $sprint_id) {
        $query
            ->select('mantis_bug_table.*')
            ->join('mantis_custom_field_string_table', 'mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id')
            ->join('mantis_project_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
            ->join('agile_projectgroups_projects', 'mantis_project_table.id', '=', 'agile_projectgroups_projects.project_id')
            ->join('agile_projectgroups', 'agile_projectgroups.id', '=', 'agile_projectgroups_projects.projectgroup_id')
            ->addSelect('mantis_bug_table.status')
            ->where('mantis_custom_field_string_table.field_id', 6)
            ->where('agile_projectgroups.id', $projectgroup_id)
            ->where('mantis_custom_field_string_table.value', $sprint_id)
            ->whereIn('mantis_bug_table.status', [10, 50, 20, 80]);
    }

    public function scopeOnGlobalSprint($query, $sprint_id) {
        $query
            ->select('mantis_bug_table.*')
            ->join('mantis_custom_field_string_table', 'mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id')
            ->join('mantis_project_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
//            ->join('agile_projectgroups_projects', 'mantis_project_table.id', '=', 'agile_projectgroups_projects.project_id')
//            ->join('agile_projectgroups', 'agile_projectgroups.id', '=', 'agile_projectgroups_projects.projectgroup_id')
            ->addSelect('mantis_bug_table.status')
            ->where('mantis_custom_field_string_table.field_id', 6)
//            ->where('agile_projectgroups.id', $projectgroup_id)
            ->where('mantis_custom_field_string_table.value', $sprint_id);
    }
}
