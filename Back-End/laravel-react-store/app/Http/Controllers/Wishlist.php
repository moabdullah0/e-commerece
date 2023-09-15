<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishhlist;
class Wishlist extends Controller
{

    public function Wishlist(){
        if(auth('sanctum')->check())
        {
            $user_id=auth('sanctum')->user()->id;
            $WishlistItems=\App\Models\Wishlist::where('user_id',$user_id)->get();
            return response()->json([
                'status'=>201,
                'message'=>'in wishlist Wishlist',
                'Wishlist'=>$WishlistItems
            ]);
        }
        else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to view  Wishlist'
            ]);
        }
    }
    public  function addtowishlist(Request $request){
        if(auth('sanctum')->check()){
            $user_id=auth('sanctum')->user()->id;
            $product_id=$request->product_id;
            $productCheck=Product::where('id',$product_id)->first();
            if($productCheck){
                if(\App\Models\Wishlist::where('product_id',$product_id)->where('user_id',$user_id)->exists()){

                    return response()->json([
                        'status'=>409,
                        'message'=>$productCheck->name.'Already added to cart',

                    ]);
                }
                else{
                    $WishlistItem=new \App\Models\Wishlist();
                    $WishlistItem->user_id=$user_id;
                    $WishlistItem->product_id=$product_id;

                    $WishlistItem->save();
                    return response()->json([
                        'status'=>201,
                        'message'=>'Added to Wishlist'

                    ]);
                }
                return response()->json([
                    'status'=>201,
                    'message'=>'Iam in cart'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Product not found'
                ]);
            }

        }
        else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to Add to Wishlist'
            ]);
        }

    }


    public function removeProductFromWishlist(Request $request, $productId)
    {
        $user = auth()->user();

        // Find the wishlist item by the product ID and user ID
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if (!$wishlistItem) {
            return redirect()->back()->with('error', 'Product not found in the wishlist.');
        }

        // Delete the wishlist item
        $wishlistItem->delete();

        return response()->json([
            'status'=>200,
            'message'=> 'Product added to the wishlist successfully.',

        ]);
    }

    public function deleteItem($WishlistId){
        if(auth('sanctum')->check())
        {
            $user = auth('sanctum')->user()->id;
           $WilistItem = \App\Models\Wishlist::where('id', $WishlistId)->where('user_id', $user)->first();
            if($WilistItem){
                $WilistItem->delete();
                return response()->json([
                    'status'=>200,
                    'message'=>'Removed Item Successfully'
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Wishlist Item not Found'
                ]);
            }


        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to view  cart'
            ]);
        }
    }
}
