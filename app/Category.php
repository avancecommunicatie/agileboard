<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table 	= 'mantis_category_table';
	protected $fillable = ['project_id', 'user_id', 'name', 'status'];
	public $timestamps 	= false;

	public function bug() {
		return $this->hasMany('App\Bug');
	}
}
