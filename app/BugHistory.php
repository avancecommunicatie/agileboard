<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BugHistory extends Model
{
	protected $table 	= 'lg_mantis.mantis_bug_history_table';
	protected $fillable = ['user_id', 'bug_id', 'field_name', 'old_value', 'new_value', 'type', 'date_modified'];
	public $timestamps 	= false;
}
