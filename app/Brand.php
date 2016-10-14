<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public static $rules = array('name' => 'required|min:3');

   

}
