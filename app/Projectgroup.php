<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projectgroup extends Model
{
    protected $table 	= 'agile_projectgroups';
    protected $fillable = ['name'];

    public function projects() {
        return $this->belongsToMany('App\Project', 'agile_projectgroups_projects', 'projectgroup_id', 'project_id');
    }

    public function stories() {
        return $this->hasMany('App\Story', 'project_id', 'id');
    }
}
