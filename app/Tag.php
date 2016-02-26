<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table 	= 'lg_mantis.mantis_tag_table';
	protected $fillable = ['user_id', 'name', 'description', 'date_created', 'date_updated'];
	public $timestamps 	= false;
}
