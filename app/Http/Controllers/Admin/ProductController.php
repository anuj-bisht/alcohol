<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    public function index(){
        $data['products']=Product::with('category')->get();
        return view('admin.product.index', $data);
    }
    public function create(){
        $data['categories']=Category::all();
        return view('admin.product.create', $data);
    }
    public function store(Request $request){


        if($files=$request->file('cover_image')){
                $name=time().rand(1,100).'.'.$files->extension();
               $path= $files->move('Alcohol', $name);


               $image=url('').'/'.$path;
        }

        $validate=Validator::make($request->all(), Product::$rules);
        $data=$validate->safe()->merge(['cover_image'=>$image])->toArray();

        $product=Product::create($data);
        if($images=$request->file('images')){
            foreach($images as $image){
                $name=time().rand(1,100).'.'.$image->extension();
                $path= $image->move('Alcohol', $name);


                $image=url('').'/'.$path;
            DB::table('product_images')->insert(['product_id'=>$product->id,'images'=>$image]);
            }

        }
        Session::flash('message', "Product Add Successfully");
        return \redirect()->route('product.show');
    }
    public function edit(Product $product){
        $data['product']=Product::with('product_images')->where('id',$product->id)->first();
        $data['categories']=Category::all();
        return view('admin.product.edit', $data);
    }
    public function update(Request $request, $id){
        if($files=$request->file('cover_image')){

            $name=time().rand(1,100).'.'.$files->extension();
           $path= $files->move('Alcohol', $name);


           $image=url('').'/'.$path;
    }else{
        $image=$request->image;
    }

        $validate=Validator::make($request->all(), Product::$rules);


        $data=$validate->safe()->merge(['cover_image'=>$image])->toArray();

        $product=Product::where('id', $id)->update($data);
        if($images=$request->file('images')){
            foreach($images as $image){
                $name=time().rand(1,100).'.'.$image->extension();
                $path= $image->move('Alcohol', $name);


                $image=url('').'/'.$path;
            DB::table('product_images')->insert(['product_id'=>$id,'images'=>$image]);
            }

        }
        Session::flash('message', "Product Edit Successfully");
        return \redirect()->route('product.show');
    }
    public function deleteImage($id)
    {

         ProductImage::where('id', $id)->delete();

        return response()->json(['message'=>'data deleted']);

    }


    public function search($data){
        $product=Product::where('name','like','%'.$data.'%')
                ->join('categories','categories.id','products.category_id')->select('products.id','products.name','categories.category_name')->get();
        return response()->json($product);
    }
}
