<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model
{
    protected $table    = 'lg_mantis.mantis_user_table';
    protected $fillable = ['username', 'realname', 'email', 'password', 'enabled', 'protected', 'access_level', 'login_count',
                           'lost_password_request_count', 'failed_login_count', 'cookie_string', 'last_visit', 'date_created'];
    public $timestamps  = false;

    public function bug() {
        return $this->hasMany('App\Bug', 'handler_id');
    }
}
