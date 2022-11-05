<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $guarded=[];
    public static $rules=[
    'name'=>'required',
    'price'=>'required',
    'category_id'=>'required',
    'description'=>'required',
    'type'=>'required',
    'alcohol_percentage'=>'required',
    'caleries'=>'required',
    'litre'=>'required'
    ];


    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function product_images(){
        return $this->hasMany(ProductImage::class,'product_id');

    }
}
