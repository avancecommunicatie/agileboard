<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $table 	= 'lg_mantis.mantis_project_table';
	protected $fillable = ['name', 'status', 'enabled', 'view_state', 'access_min', 'file_path', 'description', 'category_id', 'inherit_global'];
	public $timestamps 	= false;
}
