<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    protected $table 	= 'agile_ticket_checkboxes';
    protected $fillable = ['bug_id', 'in_de_mededeling', 'akkoord_klant'];
    public $timestamps 	= true;
}