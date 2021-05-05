<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
//---------------------------------------------------------------------------
class ProductsController extends Controller
{
    public function index()
    {
       $sections = sections::all();
       $products = products::all();
        return view('products.products', compact('sections','products'));
    }
    //---------------------------------------------------------------------------
    public function create()
    {
        //
    }
    //---------------------------------------------------------------------------
    public function store(Request $request)
    {
        products::create([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'discription' => $request->discription,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('products');
    }
    //---------------------------------------------------------------------------
    public function show(products $products)
    {
        //
    }
    //---------------------------------------------------------------------------
    public function edit(products $products)
    {
        //
    }
    //---------------------------------------------------------------------------
    public function update(Request $request)
    {
       $id = sections::where('section_name', $request->section_name)->first()->id;

       $Products = Products::findOrFail($request->pro_id);

       $Products->update([
       'Product_name' => $request->Product_name,
       'discription' => $request->discription,
       'section_id' => $id,
       ]);

       session()->flash('Edit', 'تم تعديل المنتج بنجاح');
       return back();
    }
    //---------------------------------------------------------------------------
    public function destroy(Request $request)
    {
        $Products = Products::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}