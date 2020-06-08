<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    public function user(){ return $this->belongsTo('App\User');    }
}
