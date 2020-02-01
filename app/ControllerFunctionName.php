<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ControllerFunctionName extends Model
{
    public function controller_name()
    {
        return $this->belongsTo('App\ControllerName');
    }
	
	
	public function permissions()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Permission');
    }

}
