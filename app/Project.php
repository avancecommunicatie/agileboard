<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $table 	= 'mantis_project_table';
	protected $fillable = ['name', 'status', 'enabled', 'view_state', 'access_min', 'file_path', 'description', 'category_id', 'inherit_global'];
	public $timestamps 	= false;

	/**
	 * Select records that have sprints attached to them.
	 * 
	 * @param $query
	 * @return mixed
	 */
	public function scopeWithSprints($query) {
		return $query->select('mantis_project_table.*')
					->addSelect(\DB::raw('COUNT(DISTINCT(mantis_custom_field_string_table.value)) as sprints'))
					->where('mantis_custom_field_string_table.field_id', 6)
					->where('mantis_custom_field_string_table.value', '!=', '')
					->join('mantis_bug_table', 'mantis_bug_table.project_id', '=', 'mantis_project_table.id')
					->join('mantis_custom_field_string_table', 'mantis_bug_table.id', '=', 'mantis_custom_field_string_table.bug_id')
					->groupBy('mantis_project_table.id')
					->orderBy('sprints', 'desc');
	}

	public function bugs() {
		return $this->hasMany('App\Bug');
	}

	public function fields() {
		return $this->belongsToMany('App\CustomField', 'mantis_custom_field_project_table', 'project_id', 'field_id')->withPivot('sequence');
	}

	public function projectgroups()
	{
		return $this->belongsToMany('App\Projectgroup', 'agile_projectgroups_projects', 'project_id', 'projectgroup_id');
	}
}
