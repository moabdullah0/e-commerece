<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Cart(){
        if(auth('sanctum')->check())
        {
            $user_id=auth('sanctum')->user()->id;
            $cartItems=Cart::where('user_id',$user_id)->get();
            return response()->json([
                'status'=>201,
                'cart'=>$cartItems
            ]);
        }
        else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to view  cart'
            ]);
        }
    }
public  function addtocart(Request $request){
if(auth('sanctum')->check()){
$user_id=auth('sanctum')->user()->id;
    $product_id=$request->product_id;
    $product_qty=$request->product_qty;
$productCheck=Product::where('id',$product_id)->first();
    if($productCheck){
if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->exists()){

    return response()->json([
        'status'=>409,
        'message'=>$productCheck->name.'Already added to cart',

    ]);
}
else{
$cartItems=new Cart;
    $cartItems->user_id=$user_id;
    $cartItems->product_id=$product_id;
    $cartItems->product_qty=$product_qty;
    $cartItems->save();
      return response()->json([
          'status'=>201,
          'message'=>'Added to cart'

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
        'message'=>'Login to Add to cart'
    ]);
}
}


    public function updatequantity($cardId, $scope)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'Login to update the cart'
            ]);
        }

        $user = auth('sanctum')->user()->id;
        $cartItem = Cart::where('id', $cardId)->where('user_id', $user)->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 404,
                'message' => 'Cart item not found'
            ]);
        }

        if ($scope === "increment") {
            $cartItem->product_qty = $cartItem->product_qty + 1;
        } elseif ($scope === "decrement") {
            if ($cartItem->product_qty > 1) {
                $cartItem->product_qty = $cartItem->product_qty - 1;
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid scope value'
            ]);
        }


        $cartItem->save();

        return response()->json([
            'status' => 200,
            'message' => 'Cart item quantity updated successfully',
            'updated_quantity' => $cartItem->product_qty
        ]);
    }





    public function deleteItem($cardId){
        if(auth('sanctum')->check())
        {
            $user = auth('sanctum')->user()->id;
            $cartItem = Cart::where('id', $cardId)->where('user_id', $user)->first();
            if($cartItem){
                $cartItem->delete();
                return response()->json([
                    'status'=>200,
                    'message'=>'Removed Item Successfully'
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Cart Item not Found'
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
