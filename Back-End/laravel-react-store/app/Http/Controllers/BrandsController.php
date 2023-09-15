<?php

namespace App\Http\Controllers;

use App\Models\brands;
use Illuminate\Http\Request;

class BrandsController extends Controller
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
        $brand=new brands();
        $brand->brand=$request->input('brand');
        $brand->save();

        return response()->json([
            'message'=>'sucess added',
        'brand'=>$brand
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(brands $brands)
    {
        $brands=brands::all();
        return response()->json([
            'Brand'=>$brands
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(brands $brands)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, brands $brands)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(brands $brands)
    {
        //
    }
}
