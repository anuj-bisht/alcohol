<?php

namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AddressType;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\PaymentMode;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\Charge;
use JWTAuth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
class OrderController extends Controller
{
    public function place_order(Request $request){
        $user  = JWTAuth::user();
        if (!isset($user->id)) {
          return response()->json(['status' => 0, 'message' => 'User does not exist', 'data' => json_decode("{}")]);
        }
        $validator = Validator::make($request->all(), [
          'user_address_id' => 'required|numeric',
          'total_price'=>'required|numeric'
        ]);

        if ($validator->fails()) {

          return response()->json(["status" => 0, "message" => $validator->errors()->first(), "data" => json_decode("{}")]);
        }
        $carts = Cart::where('user_id', $user->id)
                ->join('products','products.id','carts.product_id')->select('carts.*','products.name')->get();

        if (count($carts) == 0) {
            return response()->json(["status" => 0, "message" => "No item in Cart or Empty Cart", "data" => json_decode("{}")]);
          } else {
            $cart_ids = array();
            foreach ($carts as $i) {

              if (!empty($i->id)) {
                array_push($cart_ids, $i->id);
              }

            }
        }
        $payment_mode = PaymentMode::where('name', 'ONLINE')->first();
        $payment_mode_id = $payment_mode->id;

        $payment_s = PaymentStatus::where('name', 'Pending')->first();
        $payment_status_id = $payment_s->id;

        $order_s = OrderStatus::where('name', 'Pending')->first();
        $order_status_id = $order_s->id;

        $total_price=$request->total_price;
        $delivery_charge = Charge::first()->delivery_charge;
        $gst = Charge::first()->tax;
        $taxCal = 1*$gst/100;
        $taxCal = 1+$taxCal;
        $amount_after_gst=$total_price*$taxCal;
        $total_cart_amount= ($amount_after_gst+$delivery_charge);
        $address = Address::where('user_id', $user->id)->where('id', $request->user_address_id)->where('is_deleted', 0)->first();
        if (empty($address)) {
          return response()->json(["status" => 0, "message" => "User Address is Empty", "data" => json_decode("{}")]);
        } else {
          $order_no = '';
          $counter = Order::count();
          if ($counter == 0) {
            $order_no = 'ORD' . date('dmy') . 1;
          } else {
            $ord = Order::orderby('id', 'desc')->first();
            $ord_id = $ord->id;
            $new_id = $ord_id + 1;
            $order_no = 'ORD' . date('dmy') . $new_id;
          }
          $address_type = AddressType::where('id', $address->address_type_id)->first();
          $address_type_name = $address_type->name;


        }

        //dd('hii');
          $order = Order::create([
            'order_no' => $order_no,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->mobile,
            'city' => $address->city??null,
            'state' => $address->state??null,
            'country' => $address->country??null,
            'address' => $address->address,
            'address_type_name' => $address_type_name,
            'zip_code' => $address->zip_code,
            'sub_total' => $total_price,
            // 'discount' => $discount,
            'gst' => $gst,
            'amount_after_gst' => $amount_after_gst,
            'delivery_charge' => $delivery_charge,
            'total' => $total_cart_amount,
            // 'delivery_instructions' => $request->delivery_instructions,
            'status' => 1,
            'order_status_id' => $order_status_id,
            'payment_status_id' => $payment_status_id,
            'payment_mode_id' => $payment_mode_id,
            'order_date'=>now(),
	    'user_lat' =>$address->latitude??'nil',
	    'user_long'=> $address->longitude??'nil',
	    'order_map_address'=> $address->map_address??'nil',
          ]);
        //   if($request->schedule_date != '')
        //       {
        //       Order::where('id',$order->id)->update(['order_date'=>$request->schedule_date]);

        //       }
        //       else
        //       {
        //         Order::where('id',$order->id)->update(['order_date'=>date('Y-m-d H:i:s')]);

        //       }
            //   Order::where('id',$order->id)->update(['addons_ids'=>rtrim($addons,',')]);
          if (!empty($order)) {
            foreach ($carts as $product) {
              OrderDetail::create([
                'order_id' => $order->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'qty' => $product->qty,
              ]);
            }


            $transaction_no = '';
            $counter2 = Transaction::count();
            if ($counter2 == 0) {
              $transaction_no = 'TRANS' . date('dmy') . 1;
            } else {
              $transaction = Transaction::orderby('id', 'desc')->first();
              $transaction_id = $transaction->id;
              $new_id2 = $transaction_id + 1;
              $transaction_no = 'TRANS' . date('dmy') . $new_id2;
            }
            $transaction = Transaction::create([
              'transaction_no' => $transaction_no,
              'user_id' => $user->id,
              'order_id' => $order->id,
              'transaction_status' => 'pending',
            ]);
            // Cart::where('user_id', $user->id)->where('restaurant_id', $request->restaurant_id)
            //   ->delete();
            $order['transaction_no'] = $transaction->transaction_no;
            return response()->json(["status" => 1, "message" => "Order Placed Successfully", "data" => $order]);
          } else {
            return response()->json(["status" => 0, "message" => "Something went wrong during placing of Order", "data" => json_decode("{}")]);
          }


      }




      public function user_order_list(Request $request)
  {

    $user  = JWTAuth::user();
    if (!isset($user->id)) {
      return response()->json(['status' => 0, 'message' => 'User does not exist', 'data' => json_decode("{}")]);
    }
    $date=now()->addDay()->format('Y-m-d');

    $list = Order::where('user_id', $user->id)->where('order_date','<=',$date)
      ->orderBy('id', 'DESC')
      ->get();
    if (count($list) > 0) {

      $new_list = array();
      foreach ($list as $i) {

        $order_status = OrderStatus::where('id', $i->order_status_id)->first();

        $order_detail = OrderDetail::where('order_id', $i->id)->get();


        $i['order_status'] = $order_status;
        $i['order_date&time'] = $i->created_at;
        $i['order_details'] = $order_detail;

        array_push($new_list, $i);
      }
      return response()->json(["status" => 1, "message" => "Order Found Successfully", "data" => $new_list]);
    } else {
      return response()->json(["status" => 0, "message" => "No Order Found", "data" => json_decode("{}")]);
    }
  }


  public function user_order_detail(Request $request)
  {
    $id = $request->id;
    $user  = JWTAuth::user();
    if (!isset($user->id)) {
      return response()->json(['status' => 0, 'message' => 'User does not exist', 'data' => json_decode("{}")]);
    }
    $order = Order::where('user_id', $user->id)
      ->where('id', $id)
      ->orderBy('id', 'DESC')
      ->first();
    if (!empty($order)) {

      $order_status = OrderStatus::where('id', $order->order_status_id)->first();
      $order_detail = '';
      $order_detail = OrderDetail::where('order_id', $order->id)->select('id', 'product_name', 'price', 'qty')->get();




      $order['order_status'] = $order_status;
      $order['order_date&time'] = $order->created_at;
      $order['order_details'] = $order_detail;
      $driver_detail = '';
    //   if ($request->language == "en") {
    //     $driver_detail = Order::join('users', 'users.id', 'orders.driver_id')
    //       ->where('orders.id', $id)
    //       ->where('orders.driver_check', 1)
    //       ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.image')
    //       ->first();
    //   } elseif ($request->language == "ar") {
    //     $driver_detail = Order::join('users', 'users.id', 'orders.driver_id')
    //       ->where('orders.id', $id)
    //       ->where('orders.driver_check', 1)
    //       ->select('users.id', 'users.name_arbic as name', 'users.email', 'users.phone', 'users.image')
    //       ->first();
    //   } else {
    //     return Helper::language_error();
    //   }

    //   $order['driver_details'] = $driver_detail;

      return response()->json(["status" => 1, "message" => "Order Detail Found Successfully", "data" => $order]);
    } else {
      return response()->json(["status" => 0, "message" => "No Order Found", "data" => json_decode("{}")]);
    }
  }


    }






