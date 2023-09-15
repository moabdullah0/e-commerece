<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Faker\Core\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $product = new Product();

            $product->title = $request->input('title');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->brand_id = $request->input('brand_id');
            $product->category_id = $request->input('category_id');
            $product->numofpeace = $request->input('numofpeace');

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = time() . rand(11111, 99999) . "." . $extension;
                $image->move(public_path('uploads'), $filename);
                $product->image = $filename;
            }

            $product->save();

            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating product',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show()
    {
       $product=Product::all();
       return response()->json([
           'Product'=>$product
       ]);
    }

    public function showproduct($id)

    {

        if(Category::where('id',$id)->exists()){

            $category= Category::where('id',$id)->first();
            $products= Product::where('category_id',$category->id)->get();


return  response()->json([

    'Category'=>$category,
    'status'=>200,
    'Product'=>$products,

]);


        }
        else{
            return redirect('/');
        }
    }

    public function edit($id){
        $product=Product::find($id);
        return response()->json([
            'Massage : '=>'product Found',
            'status'=>200,
            'Product'=>$product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $product=Product::find($id);

        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->brand_id = $request->input('brand_id');
        $product->category_id = $request->input('category_id');
        $product->numofpeace = $request->input('numofpeace');

        // Handle image upload
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . rand(11111, 99999) . "." . $extension;
            $image->move(public_path('uploads'), $filename);
            $product->image = $filename;
        }
        $product->update();
        return response()->json(['Products '=>$product,'message'=>'Product update sucessfuly']);

    }

    /**
     * Remove the specified resource from storage.
     */

    public function ProductDetailes($id){
        $product = Product::find($id);
        return response()->json([
          'Product' => $product,
            'status'=>200
        ]);
    }
    public function destroy($id)
    {
        $product=Product::find($id);
        $product->delete();
        return response()->json(['message :'=>'deleted Sucessfly']);
    }
}
