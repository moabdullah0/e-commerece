<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';

 protected $fillable=['id','title','name','descriprion',
     'product_id','user_id','quantity'
     ,'phone','address','price',
     'email'];

 public function order_detailes(){
     return $this->hasMany(Orderdetailes::class,'order_id','id');
 }

}
