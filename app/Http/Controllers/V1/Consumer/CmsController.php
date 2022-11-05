<?php

namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;

class CmsController extends Controller
{
    public function privacy(){
        $data = Cms::select('privacy_policy')->first();
        return response()->json(['status' => 1, 'message' => 'Success', 'data' => $data]);

    }
    public function terms_condition(){
       $data= Cms::select('terms_and_condition')->first();
        return response()->json(['status' => 1, 'message' => 'Success', 'data' => $data]);
    }
}
