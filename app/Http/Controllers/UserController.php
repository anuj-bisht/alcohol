<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\OrderDetail;
class UserController extends Controller
{
    public function index(){
     $data['users']=User::where('role',2)->get();
     return view('admin.user.index', $data);
    }


   public function changeStatus($user_id, $value){
    if($value=='yes'){
        User::where('id',$user_id)->update(['doc_verified'=>1]);
        return response()->json(['status'=>'User Activated']);
    }elseif($value=='no'){
        User::where('id',$user_id)->update(['doc_verified'=>0]);
        return response()->json(['status'=>'User Deactivated']);
    }
    }


    public function view(User $user){
        $data['user']=$user;


        $date=now()->addDay()->format('Y-m-d');

        $list = Order::where('user_id', $data['user']->id)->where('order_date','<=',$date)
          ->orderBy('id', 'DESC')
          ->get();


          $new_list = array();
          foreach ($list as $i) {

            $order_status = OrderStatus::where('id', $i->order_status_id)->first();
            $order_detail = OrderDetail::where('order_id', $i->id)->get();
            $payment_status = PaymentStatus::where('id', $i->payment_status_id)->first();


            $i['payment_status'] = $payment_status;
            $i['order_status'] = $order_status;
            $i['order_date&time'] = $i->created_at;
            $i['order_details'] = $order_detail;

            array_push($new_list, $i);
          }
          $data['new_list']=$new_list;
        return view('admin.user.view', $data);



    }

}
