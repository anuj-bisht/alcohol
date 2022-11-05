<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index(Category $category){
        $data['categories']=$category->all();
        return view('admin.category.index', $data);
    }
    public function create(){
        return view('admin.category.create');
    }
    public function store(Request $request){
        $validate=Validator::make($request->all(), Category::$rules);
        Category::create($validate->validated());
        Session::flash('message', "Category Add Successfully");
        return \redirect()->route('category.show');
    }
    public function edit(Category $category){
        $data['category']=$category;
        return view('admin.category.edit', $data);
    }
    public function update(Request $request, $id){
        $validate=Validator::make($request->all(), Category::$rules);
        Category::where('id', $id)->update($validate->validated());
        Session::flash('message', "Category Edit Successfully");
        return \redirect()->route('category.show');
    }
    public function delete($id)
    {

         Category::where('id', $id)->delete();

        return response()->json(['message'=>'data deleted']);

    }
}
