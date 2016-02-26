<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
	protected $table 	= 'lg_mantis.mantis_bug_table';
	protected $fillable = ['project_id', 'reporter_id', 'handler_id', 'duplicate_id', 'priority', 'severity', 'reproducibility', 'status', 'resolution', 'projection', 'eta',
							'bug_text_id', 'os', 'os_build', 'platform', 'version', 'fixed_in_version', 'build', 'profile_id', 'view_state', 'summary', 'sponsorship_total',
							'sticky', 'target_version', 'category_id', 'date_submitted', 'due_date', 'last_updated'];
	public $timestamps 	= false;

	public function user() {
		return $this->belongsTo('App\User', 'handler_id');
	}
}
