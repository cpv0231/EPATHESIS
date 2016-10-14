<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded =[];
	protected $fillable = array('subcategories_id', 'title', 'description', 'price', 'stocks', 'image');

	public static $rules = array(
		'subcategories_id'=>'required|integer',
		'title'=>'required|min:2',
		'description'=>'required|min:20',
		'price'=>'required|numeric',
		'stocks'=>'integer',
		'image'=>'required|image|mimes:jpeg,jpg,bmp,png,gif'
	);

	public static $rulesUpdate = array(
		'subcategories_id'=>'required|integer',
		'title'=>'required|min:2',
		'description'=>'required|min:20',
		'price'=>'required|numeric',
		'stocks'=>'integer'
	);

	

	
}