<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bugnote extends Model
{
	protected $table = 'mantis_bugnote_table';
	protected $fillable = ['bug_id', 'reporter_id', 'bugnote_text_id', 'view_state', 'note_type', 'note_attr', 'time_tracking', 'last_modified', 'date_submitted'];
	public $timestamps 	= false;

	public function bug() {
		return $this->belongsTo('App\Bug');
	}

	public function reporter() {
		return $this->belongsTo('App\User', 'reporter_id');
	}

	public function bugnoteText() {
		return $this->belongsTo('App\BugnoteText');
	}
}
