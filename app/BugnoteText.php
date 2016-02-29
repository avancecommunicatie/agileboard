<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BugnoteText extends Model
{
	protected $table = 'mantis_bugnote_text_table';
	protected $fillable = ['note'];
	public $timestamps 	= false;

	public function bugnote() {
		return $this->hasMany('App\Bugnote');
	}
}
