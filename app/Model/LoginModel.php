<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    public $table = 'app';
    //public $table = 'login';

    protected  $primaryKey = 'id';

    public $timestamps = false;
}
