<?php



use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;


function ConsumerCount(){
    $Consumercount=User::where('role',2)->count();
    return $Consumercount;
}

function TotalCategory(){
    $Totalcategory=Category::where('status',1)->count();
    return $Totalcategory;
}

function TotalProduct(){
    $Totalproduct=Product::where('status',1)->count();
    return $Totalproduct;
}

function allconsumer(){
    $allconsumer=User::where('role',2)->get();
    return $allconsumer;
}

function Totalsale(){
    $totalsale=Order::where('order_status_id',1)->sum('total');

    return $totalsale;
}
