<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackProducts extends Model
{
	 protected $fillable = ['user_id','product_id', 'countview'];
    	
     public function Products(){
    	return $this->belongsTo('App\Product', 'product_id');
    }
}
