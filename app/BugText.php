<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BugText extends Model
{
    protected $table = 'mantis_bug_text_table';
	protected $fillable = ['description', 'steps_to_reproduce', 'additional_information'];
	public $timestamps 	= false;

	public function bug() {
		return $this->hasOne('App\Bug');
	}
}
