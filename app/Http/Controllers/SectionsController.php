<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//---------------------------------------------------------------------------
class SectionsController extends Controller
{
    public function index()
    {
        $sections = Sections::all();
        return view('sections.section', compact('sections'));
        // return "مرحبا بك في صفحة الاقسام ";
    }
    //---------------------------------------------------------------------------
    public function create()
    {
        //
    }
    //---------------------------------------------------------------------------
    public function store(Request $request)
    {

        $validated = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'discription' => 'required',
        ],
        [
            'section_name.required' => 'خطأ يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم موجود مسبقاً',
            'discription.required' => 'خطأ يرجى ادخال البيانات',
        ]);

        sections::create([
            'section_name' => $request->section_name,
            'discription' => $request->discription,
            'created_by' => (Auth::user()->name),
        ]);

            session()->flash ('Add' , 'تمت اضافة القسم بنجاح');
            return redirect('section') ;
    }

    public function show(sections $sections)
    {
        //
    }
    //---------------------------------------------------------------------------
    public function edit(sections $sections)
    {
        //
    }
    //---------------------------------------------------------------------------
    public function update(Request $request)
    {

        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'discription' => 'required',
        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'discription.required' =>'يرجي ادخال البيان',

        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'discription' => $request->discription,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('section');
    }
    //---------------------------------------------------------------------------
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('section');
    }
}
