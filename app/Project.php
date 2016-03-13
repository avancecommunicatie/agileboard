<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $table 	= 'lg_mantis.mantis_project_table';
	protected $fillable = ['name', 'status', 'enabled', 'view_state', 'access_min', 'file_path', 'description', 'category_id', 'inherit_global'];
	public $timestamps 	= false;

	public function bugs() {
		return $this->hasMany('App\Bug');
	}

	public function stories() {
		return $this->hasMany('App\Story');
	}

	public function fields() {
		return $this->belongsToMany('App\CustomField', 'lg_mantis.mantis_custom_field_project_table', 'project_id', 'field_id')->withPivot('sequence');
	}
}
