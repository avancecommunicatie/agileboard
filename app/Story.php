<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table 	= 'lg_agile.stories';
    protected $fillable = ['projectgroup_id', 'subject', 'content'];

    public function projectgroup() {
        return $this->belongsTo('App\Projectgroup');
    }
}
