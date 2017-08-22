<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
	protected $table 	= 'mantis_custom_field_table';
	protected $fillable = ['name', 'type', 'possible_values', 'status', 'default_value', 'valid_regexp', 'access_level_r', 'access_level_rw',
							'length_min', 'length_max', 'require_report', 'require_update', 'display_report', 'display_update', 'require_resolved',
							'display_resolved', 'display_closed', 'require_closed', 'filter_by'];
	public $timestamps 	= false;

	public function projects() {
		return $this->belongsToMany('App\Project', 'mantis_custom_field_project_table', 'field_id', 'project_id')->withPivot('sequence');
	}

	public function bugs() {
		return $this->belongsToMany('App\Bug', 'mantis_custom_field_string_table', 'field_id', 'bug_id')->withPivot('value');
	}
}

