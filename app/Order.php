<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
      protected $fillable = ['user_id','address','total'];

      public function orderItems(){
      	return $this->belongsToMany('App\Product' , 'orders_lines')->withPivot('amount','price','total');
      }
  
}
