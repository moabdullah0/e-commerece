<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlists';

    protected $fillable = [
        'id',
        'user_id',
        'product_id',
    ];
    protected $with=['user','product'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
