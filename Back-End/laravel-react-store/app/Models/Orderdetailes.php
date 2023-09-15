<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetailes extends Model
{
    use HasFactory;
    protected $table='order_detailes';
    protected $fillable=['id','quantity','order_id','price','discount','total_price','product_id'];

    protected $with=['product','orders','users'];
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function orders(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function users(){
        return $this->belongsTo(Order::class,'user_id','id');
    }
}
