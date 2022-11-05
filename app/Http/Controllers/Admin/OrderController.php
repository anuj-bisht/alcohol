<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Order $order){
     $orders=$order::join('payment_status','payment_status.id','orders.payment_status_id')
            ->join('order_status','order_status.id','orders.order_status_id')
            ->select('orders.id','orders.order_no','orders.name','orders.phone','orders.total','payment_status.name as payment_status','order_status.name as order_status')->get();
     return view('admin.order.index', compact('orders'));
    }


    public function view($id){
        $order=Order::where('orders.id',$id)
            ->join('payment_status','payment_status.id','orders.payment_status_id')
            ->join('order_status','order_status.id','orders.order_status_id')
            ->join('payment_modes','payment_modes.id','orders.payment_mode_id')
            ->select('orders.sub_total','orders.order_no','orders.delivery_charge','orders.name','orders.address','orders.phone','orders.zip_code','orders.email','orders.amount_after_gst','orders.gst','orders.total','payment_status.name as payment_status','order_status.name as order_status','payment_modes.name as payment_mode')->first();
            return view('admin.order.view',compact('order'));

    }




}
