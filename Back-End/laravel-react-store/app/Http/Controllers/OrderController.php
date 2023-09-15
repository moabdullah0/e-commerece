<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderdetailes;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Store a newly created resource in storage.
     */

    public function orders(Request $request)
    {
        if (auth('sanctum')->check()) {
            $user = auth('sanctum')->user()->id;
            $CART = Cart::where('user_id', $user)->get();

            $order = new Order();
            $order->user_id = $user;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->save();

            $cartItems = [];
            $total_price = 0;

            foreach ($CART as $items) {
                $product_price = $items->product->price;
                $cartItems[] = [

                    'product_id' => $items->product_id,
                    'quantity' => $items->product_qty,
                    'price' => $product_price,
                    'total_price' => $product_price * $items->product_qty,
                ];
                if ($items->product->numofpeace < $items->product_qty) {
                    return response()->json([
                        'status' => 405,
                        'message' => 'quantity Not found',
                    ]);
                } else {
                    $items->product->update([
                        'numofpeace' => $items->product->numofpeace - $items->product_qty,
                    ]);

                    // Add the total price for this item to the overall total
                    $total_price += $product_price * $items->product_qty;
                }
            }

            $order->order_detailes()->createMany($cartItems);
            Cart::destroy($CART);
            return response()->json([
                'status' => 200,
                'message' => 'Successfully created the order',
                'order_id' => $order->id,
                'total_price' => $total_price,
            ]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function showorder()
    {
        $order=Orderdetailes::all();
        return response()->json([
            'Order'=>$order,
            'status'=>200,


        ]);
    }

    public function orderdetailes($id) {
        $order = Orderdetailes::where('order_id', $id)->get();

        if ($order->isEmpty()) {
            return response()->json([
                'error' => 'No order details found for the given order ID.',
                'status' => 404,
            ]);
        }

        return response()->json([
            'Order' => $order,
            'status' => 200,
        ]);
    }

    public function sailesfilter(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Query the 'orders' table with whereMonth and whereYear
        $orders = Orderdetailes::whereMonth('created_at', $month)->whereYear('created_at', $year)->get();

        $totalSales = $orders->sum('total_price');

        return response()->json([
            'order' => $orders,
            'total_sales' => $totalSales,
            'status' => 200
        ]);
    }


}
