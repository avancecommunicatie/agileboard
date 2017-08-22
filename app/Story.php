<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table 	= 'agile_stories';
    protected $fillable = ['projectgroup_id', 'subject', 'content'];

    public function projectgroup() {
        return $this->belongsTo('App\Projectgroup');
    }
}
