<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car';

    protected  $primaryKey = 'sid';

    public $timestamps = false;
}
