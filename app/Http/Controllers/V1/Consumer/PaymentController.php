<?php

namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Razorpay\Api\Api;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Errors\SignatureVerificationError;


class PaymentController extends Controller
{
    public function generatePaymentId(Request $request){

        try{
          $status = 0;
          $message = "";
          $user  = JWTAuth::user();


          $validator = Validator::make($request->all(), [
            'transaction_no' => 'required'
          ]);

          $params = [];
          if($validator->fails()){

            return response()->json(["status"=>$status,"message"=>$validator->errors()->first(),"data"=>json_decode("{}")]);
          }
          $order_detail=Transaction::join('orders','orders.id','transactions.order_id')->where('transaction_no',$request->transaction_no)->select('orders.id','orders.total','transactions.id as transaction_id')->first();
          if(!isset($order_detail)){
            return response()->json(["status"=>$status,"message"=>"Wrong Transaction Number","data"=>json_decode("{}")]);
          }
          else{


                 if(isset($order_detail->id)){
           $amount = ($order_detail->total)*100;
           $receipt = 'order_'.uniqid();
        //    $key = env('RAZOR_LIVE_KEY');
        //    $secret = env('RAZOR_LIVE_SECRET');

            $api = new Api('rzp_test_O69lieTba9FGDf','tppRbRqo8m0xdnPipdOoKT5E');

            $data  = $api->order->create(array('receipt' => $receipt, 'amount' => $amount, 'currency' => 'INR')); // Creates order

            if (empty($data)) {
              $data = FALSE;
            } else {
                $result = $data;
                if(!isset($result->receipt)){
                  return response()->json(['status'=>$status,'message'=>'Error','data'=>$result]);
                }
                $transaction=Transaction::find($order_detail->transaction_id);

                 $transaction->razor_order_id = $result->receipt;
                 $transaction->amount = $result->amount/100;
                 $transaction->razor_id = $result->id;
                 $transaction->currency = $result->currency;
                if($transaction->save()){
                  return response()->json(['status'=>1,'message'=>'RazorId Created SuccessFully','data'=>$transaction]);
                }
            }
          }else{
            return response()->json(['status'=>$status,'message'=>'No plan exist','data'=>json_decode("{}")]);
          }
          }
        }catch(Exception $e){
          return response()->json(['status'=>$status,'message'=>$e->getMessage(),'data'=>json_decode("{}")]);
        }

      }





      public function verifyPayment(Request $request){

        try{
          $status = 0;
          $message = "";

          $user  = JWTAuth::user();

          if(!isset($user->id)){
            return response()->json(["status"=>$status,"message"=>'User does not exist',"data"=>json_decode("{}")]);
          }

          $key = env('RAZOR_LIVE_KEY');
          $secret = env('RAZOR_LIVE_SECRET');


           $api = new Api('rzp_test_O69lieTba9FGDf','tppRbRqo8m0xdnPipdOoKT5E');

           $validator = Validator::make($request->all(), [
            'razorpay_payment_id' => 'required',
            'razorpay_order_id'=>'required',
            'razorpay_signature'=>'required',
            'order_id'=>'required',
          ]);

          if($validator->fails()){
            $error = json_decode(json_encode($validator->errors()));
            if(isset($error->razorpay_payment_id[0])){
                $error = $error->razorpay_payment_id[0];
            }else if(isset($error->razorpay_order_id[0])){
                $error = $error->razorpay_order_id[0];
            }else if(isset($error->razorpay_signature[0])){
                $error = $error->razorpay_signature[0];
            }
            return response()->json(["status"=>$status,"message"=>$error,"data"=>json_decode("{}")]);
          }

      //dd("hi", $request->all());
          $success = false;
          if (!empty($request->razorpay_payment_id)) {

          try
              {
                  $attributes = array(
                      'razorpay_order_id' => $request->razorpay_order_id,
                      'razorpay_payment_id' => $request->razorpay_payment_id,
                      'razorpay_signature' => $request->razorpay_signature
                  );

                  $api->utility->verifyPaymentSignature($attributes);
                  $success = true;
              }
              catch(SignatureVerificationError $e)
              {
                  $success = false;
                  $error = 'Razorpay Error : ' . $e->getMessage();
                  $html = "<p>Your payment failed</p><p>{$error}</p>";

                  return response()->json(['status'=>0,'message'=>$html,'data'=>$html]);
              }

          }

          if ($success === true)
          {

              $orderData = Transaction::where('razor_order_id',$request->order_id)->orWhere('razor_id', $request->razorpay_order_id)->first();

              if(isset($orderData->id)){
                       $subs = Transaction::find($orderData->id);
                       $subs->transaction_status="success";
                  }
                  if($subs->save()){
                    $order_table = Order::find($orderData->order_id);
                       $order_table->payment_status_id=1;
                       $order_table->save();
                      $schedule_array = array("123", "246");
                      $rand_keys = array_rand($schedule_array, 1);


                      return response()->json(['status'=>1,'message'=>"Payment success/ Signature Verified",'data'=>'success']);

              }else{
                  return response()->json(['status'=>0,'message'=>'Order does not exist','data'=>json_decode("{}")]);
                  }


                }
                else{
                  $html = "<p>Your payment failed</p><p></p>";

                  return response()->json(['status'=>0,'message'=>$html,'data'=>$html]);
              }
              }
          catch(Exception $e){
               return response()->json(['status'=>$status,'message'=> $e->getMessage(),'data'=>json_decode("{}")]);
        }

      }





}
