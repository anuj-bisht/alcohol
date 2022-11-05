<?php

namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    public function categoryProduct(Request $request){
    try {
        $product=Product::where('category_id', $request->id)->get();
        if(count($product) < 1){
            return response()->json(["status" =>0, "message" =>"No Product Found", "data" => [] ]);

        }
        return response()->json(["status" =>1, "message" =>"Product Fetch Successfully", "data" => $product ]);

    } catch (\Exception $e) {
        return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);

    }
    }
    public function productDetail(Request $request){
        try {
            $product=Product::with(['product_images','category'])->where('id', $request->id)->first();
            if(!isset($product)){
                return response()->json(["status" =>0, "message" =>"Product Does Not Exist", "data" => json_decode("{}") ]);
            }
            return response()->json(["status" =>1, "message" =>"Product Fetch Successfully", "data" => $product ]);

        } catch (\Exception $e) {
            return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);

        }
        }

        public function searchProduct(Request $request){
            $product_name=(string)$request->product_name;
                    $product=Product::where('name','like','%'.$product_name.'%')->with(['product_images','category'])->get();
                    if(count($product) == 0){
                        return response()->json(["status" =>0, "message" =>"Product Does Not Exist", "data" => [] ]);
                    }
                    else{
                        return response()->json(["status" =>1, "message" =>"Product Fetch Successfully", "data" => $product]);

                    }
                        }
}
