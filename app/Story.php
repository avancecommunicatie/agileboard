<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table 	= 'lg_agile.stories';
    protected $fillable = ['project_id', 'subject', 'content'];

    public function projects() {
        return $this->belongsTo('App\Project');
    }
}
