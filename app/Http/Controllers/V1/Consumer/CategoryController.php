<?php

namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Tymon\JWTAuth\Facades\JWTAuth;
class CategoryController extends Controller
{
    public function index(){
     $data=Category::all();
     return response()->json(['status'=>1, 'message'=>'Category Fetch Successfully', 'data'=> $data]);

    }
}
