<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Songs extends Model
{
    
    protected $table    = 'songs';
    protected $fillable = ['band', 'song'];
    
    
    
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
