<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Problem extends Model
{
    
    protected $fillable = ['description', 'category_id', 'drill_id', ];
    
    //public function drills()
    //{
    //    return $this->belongsTo('App\Drill');
    //}
}
