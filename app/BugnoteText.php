<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BugnoteText extends Model
{
    protected $table 	= 'lg_mantis.mantis_bugnote_text_table';
	protected $fillable = ['note'];
	public $timestamps 	= false;
}
