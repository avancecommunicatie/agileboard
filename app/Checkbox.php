<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    protected $table 	= 'agile_checkboxes';
    protected $fillable = ['id', 'name'];

    public function bugs() {
        return $this->belongsToMany('App\Bug', 'agile_bug_checkbox', 'checkbox_id', 'bug_id');
    }

    public function scopeEnabled($query)
    {
        $query->where('disabled', 0);
    }
}