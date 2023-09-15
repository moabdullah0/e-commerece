<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $category=new Category();

        $category->title=$request->input('title');
        $category->description=$request->input('description');

        // handle image upload
        if ($request->hasfile('image')) {
            $image= $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time()  .rand(11111, 99999). "." . $extension;
            $image->move(public_path('image'), $filename);
            $category['image'] = $filename;
        }

        $category->save();

        return response()->json([
            'message' => 'category created successfully',
            'category' => $category
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $category=Category::all();
        return response()->json([
            'Category'=>$category,
            'status'=>200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $category=Category::find($id);
        return response()->json([
            'Massage : '=>'Category Found',
            'status'=>200,
            'Category'=>$category,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $categories=Category::find($id);

        $categories->title=$request->input('title');
        $categories->description=$request->input('description');


        if ($request->hasfile('image')) {
            $image= $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time()  .rand(11111, 99999). "." . $extension;
            $image->move(public_path('image'), $filename);
            $categories['image'] = $filename;
        }

        $categories->update();
        return response()->json([
            'Message'=>'Success_updated',
            'Category'=>$categories
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'Message'=>'Sucessfly deleted',
            'Category'=>$category
        ]);
    }
}
