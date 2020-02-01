<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = [
        'user_id','ticket_no', 'start_date', 'end_date','description'
    ];	
	
	public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
	
	public function assigned_admin(){
        return $this->belongsTo('App\User','user_assigned_id','id');
    }
}
