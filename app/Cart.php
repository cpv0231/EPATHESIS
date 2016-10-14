<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id','product_id', 'amount','total', 'price'];
    
    public function Products(){
    	return $this->belongsTo('App\Product', 'product_id');
    }


}
