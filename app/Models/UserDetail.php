<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table      = 'user_details';

    public $timestamps = false;

    protected $guarded    = ['id'];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
