<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $fillable = ['game_id','cows','bulls','number_to_guess', 'error'];

    public function game()
   {
       return $this->belongsTo('App\Attempt');
   }
}
