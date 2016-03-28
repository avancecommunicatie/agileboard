<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projectgroup extends Model
{
    protected $table 	= 'lg_agile.projectgroups';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'lg_agile.projectgroups_projects', 'projectgroup_id', 'project_id');
    }
}
