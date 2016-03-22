<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projectgroup extends Model
{
    protected $table 	= 'lg_agile.projectgroups';
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'projectgroups_project', 'projectgroup_id', 'project_id');
    }
}
