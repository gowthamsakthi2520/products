<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Category;
use App\Models\ProductVariant;

class Products extends Model
{
    protected $table='products';
    protected $guarded = [];

    public function category_name(){
        return $this->belongsTo(category::class,'category','id');
    }

    public function product_variants(){
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }
}


