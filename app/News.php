<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	protected $table 	= 'lg_mantis.mantis_news_table';
	protected $fillable = ['project_id', 'poster_id', 'view_state', 'announcement', 'headline', 'body', 'last_modified', 'date_posted'];
	public $timestamps 	= false;
}
