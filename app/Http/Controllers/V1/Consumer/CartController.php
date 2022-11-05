<?php

namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use Exception;
use JWTAuth;

class CartController extends Controller
{
    public function addToCart(Request $request){
       try {
        $user=JWTAuth::user();
        if(!isset($user)){
            return response()->json(["status" => 0,  "message" => "User Not Found, Please Register First", "data" => json_decode("{}") ]);
        }else{
            if($user->age > 21 && $user->doc_verified == '1'){
                $check=Cart::where('user_id',$user->id)
                        ->where('product_id',$request->product_id)
                        ->get();
                if(isset($check[0])){
                  $cart=Cart::find($check[0]->id);
                  $cart->qty=$request->qty;
                  try{
                    if($cart->save()){
                        return response()->json(["status" => 1,  "message"=>"Cart Update Successfully", "data" => $cart ]);

                    }
                }catch(Exception $e){
                    return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);

                }
                }
                else{
                    $cart=new Cart;
                    $cart->user_id=$user->id;
                    $cart->product_id=$request->product_id;
                    $cart->qty=$request->qty;
                    $cart->price=$request->price;
                    try{
                        if($cart->save()){
                            return response()->json(["status" => 1,  "message"=>"Product is save in your cart", "data" => $cart ]);

                        }
                    }catch(Exception $e){
                        return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);

                    }
                }

            }
            else{
                return response()->json(["status" => 0,  "message" => "Your age must be greater than 21 OR Admin cannot allow you to order the products.", "data" => json_decode("{}") ]);

            }
        }

       } catch (Exception $e) {
        return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);
       }
    }

    public function updateCart(Request $request){
        try {
         $user=JWTAuth::user();

         if(!isset($user)){
             return response()->json(["status" => 0,  "message" => "User Not Found, Please Register First", "data" => json_decode("{}") ]);
         }

         $cart=Cart::find($request->cart_id);
         $cart->qty=$request->qty;
         try{
            if($cart->save()){
                $data= User::with(['cart'=>function($cart){
                    $cart->with(['product'=>function($product){
                       $product->with('product_images')->get();
                    }])->get();
                   }])->where('id',$user->id)->select('users.id','users.email','users.name','users.mobile')->first();
                   // $data->cart;
                   $total=[];
       foreach($data->cart as $dat){
           array_push($total,$dat->qty*$dat->price);
       }
       $data['total_price']=array_sum($total);
                   return response()->json(["status" => 1,  "message" => "Cart Update Successfully", "data" => $data ]);

                // return response()->json(["status" => 1,  "message"=>"Cart Update Successfully", "data" => $cart ]);

            }
        }catch(Exception $e){
            return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);

        }

        } catch (Exception $e) {
         return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);
        }
     }


     public function Cart(Request $request){
 try {
            $user=JWTAuth::user();
            $data= User::with(['cart'=>function($cart){
             $cart->with(['product'=>function($product){
                $product->with('product_images')->get();
             }])->get();
            }])->where('id',$user->id)->select('users.id','users.email','users.name','users.mobile')->first();
            if(count($data->cart) > 0) {
            $total=[];
            foreach($data->cart as $dat){
                array_push($total,$dat->qty*$dat->price);
                }
            $data['total_price']=array_sum($total);
            return response()->json(["status" => 1,  "message" => "Your Cart Items", "data" => $data  ]);
            }else{
                return response()->json(["status" => 0,  "message" => "No items found in your cart", "data" => [] ]);

            }

           } catch (Exception $e) {
            return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);
           }
            }

     public function deleteCart(Request $request){
        try {
            $user=JWTAuth::user();
             $cart=Cart::where('id',$request->id)->delete();
             if($cart == 0){
                return response()->json(["status" => 0,  "message" => 'Cart item not exist', "data" => json_decode("{}") ]);

             }else{
             return response()->json(["status" => 1,  "message" => 'Cart item delete successfully', "data" => $cart ]);
             }
           } catch (Exception $e) {
            return response()->json(["status" => 0,  "message" => $e->getMessage, "data" => json_decode("{}") ]);
           }
     }

    }
