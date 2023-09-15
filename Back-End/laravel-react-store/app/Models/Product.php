<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'brand_id',
        'category_id',
        'numofpeace',
        'status',
        'image', // remove 'image' from the $hidden array
    ];

    protected $table='product';
    public function Wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

}
