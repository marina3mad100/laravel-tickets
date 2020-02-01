<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControllerName extends Model
{
    public function functions_names()
    {
        return $this->hasMany('App\ControllerFunctionName');
    }
}
