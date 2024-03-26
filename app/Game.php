<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['user_name','completed','start_game','end_game'];

    public function  attempts()
   {
       return $this->hasMany('App\Attempt');
   }
}
