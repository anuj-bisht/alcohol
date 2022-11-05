<?php
namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use GuzzleHttp\Client;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function ConsumerRegister(Request $request)
    {

        $validator = Validator::make($request->all() , ["name" => "required|string|max:255", "email" => "required|string|email|max:100|unique:users", "age" => 'required', "mobile" => "required|numeric|unique:users", 'address' => 'required', 'doc' => 'required|image']);

        //$validator->errors()
        if ($validator->fails())
        {

            return response()
                ->json(['status' => 0, 'message' => $validator->errors()
                ->first() , 'data' => []]);

        }

        $data = [];

        $otp = rand(111111, 999999);
        $data["otp"] = $otp;

        if ($files = $request->file('doc'))
        {
            $name = time() . rand(1, 100) . '.' . $files->extension();
            $path = $files->move('docs', $name);

            $image = url('') . '/' . $path;
        }

        $user = User::create([

        "name" => $request->name, "email" => $request->email, "mobile" => $request->mobile, "age" => $request->age, "role" => 2, "password" => Hash::make($request->get("123456@!")) , "otp" => $otp, "verified_otp" => 0, "doc" => $image, "doc_verified" => 0, ]);
        if (isset($user))
        {
            $address = new Address();
            $address->user_id = $user->id;
            $address->address = $request->address;
 	   $address->address_type_id=$request->address_type_id;
            $address->zip_code=$request->zip_code;
            $address->save();
        }
        // $user->assignRole('consumer');
        $token = JWTAuth::fromUser($user);

        $update = DB::table("users")->where("id", $user->id)
            ->update(["remember_token" => $token]);
        if ($user != null && $user->count() > 0)
        {
            $phone = $user->mobile;
            $message = "Your OTP to log in to your account is" . " " . "$otp" . "." . " " . "Do not share your OTP with anyone. - Team WheelSniffer";

            $client = new Client();
            $url = "http://sendsms.designhost.in/index.php/smsapi/httpapi/";
            $response = $client->put($url, ['headers' => ['Content-type' => 'application/json'], 'json' => ['uname' => 'wheelsniffer', 'password' => '654321', 'sender' => 'WHLSNF', 'tempid' => '1707165097449419397', 'receiver' => $phone, 'route' => 'TA', 'msgtype' => '1', 'sms' => $message, 'format' => 'json'], ]);
            if ($response->getStatusCode() == 200)
            { // 200 OK
                $response_data = $response->getBody()
                    ->getContents();

            }

            $uname = 'wheelsniffer';
            $passwordd = '654321';
            $sender = 'WHLSNF';
            //  $tempid = '1707165097449419397';
            $route = 'TA';
            $msgtype = '1';

            return response()->json(['status' => 1, "message" => "User successfully registered", "user" => array_merge($user->toArray() , $address->toArray()) , 'token' => $token], 201);
            //         if($this->SendSms($phone,$message,$uname,$passwordd,$sender,$route,$msgtype)){
            //             $notification->user_id=$user->id;
            //             $notification->title="Consumer have Registered Successfully";
            //             $notification->message=$user->name." "."have registered as a consumer";
            //             $notification->type="Cregister";
            //             $notification->save();
            // return response()->json(
            //     [
            //         'status'=>1,
            //         "message" => "User successfully registered",
            //         "user" => $user,
            //         'token'=>$token
            //     ],
            //     201
            // );
            //         }
            //     } else {
            //         return response()->json([
            //             "status" => 0,
            //             "responseCode" => "NP997",
            //             "message" => "User not found. please register first",
            //             "data" => json_decode("{}"),
            //         ]);
            //     }

        }
    }

    public function sendOtp(Request $request)
    {

        try
        {
            $status = 0;
            $message = "";

            $validator = Validator::make($request->all() , ["mobile" => "required|numeric|min:10", ]);

            if ($validator->fails())
            {
                $error = json_decode(json_encode($validator->errors()));
                if (isset($error->mobile[0]))
                {
                    $message = $error->mobile[0];
                }

                return response()
                    ->json(["status" => $status, "responseCode" => "NP997", "message" => $message, "data" => json_decode("{}") , ]);
            }

            $userList = User::where("mobile", $request->mobile)
                ->first();
            if (!isset($userList))
            {
                return response()->json(["status" => 0, "message" => "User Not Exist, Please Register First", "data" => json_decode("{}") , ]);
            }

            // if($userList->role===2){
            //     return response()->json([
            //         "status" => 0,
            //         "message" => "You Are Not A Provider Please Register First As A Provider",
            //         "data" => json_decode("{}"),
            //     ]);
            // }
            // else{
            $otp = rand(100000, 999999);
            //$otp = 123456;
            if ($userList != null && $userList->count() > 0)
            {
                $phone = $request->mobile;
                $message = "Your OTP to log in to your account is" . " " . "$otp" . "." . " " . "Do not share your OTP with anyone. - Team WheelSniffer";

                // $client = new Client();
                // $url = "http://sendsms.designhost.in/index.php/smsapi/httpapi/";
                //   $response = $client->put($url,[
                //      'headers' => ['Content-type' => 'application/json'],
                //      'json' => ['uname' => 'wheelsniffer',
                //      'password' => '654321',
                //      'sender' => 'WHLSNF',
                //      'tempid' => '1707165097449419397',
                //      'receiver' => $phone,
                //      'route' => 'TA',
                //      'msgtype' => '1',
                //      'sms' => $message,
                //      'format' => 'json'
                //          ],
                //  ]);
                // if ($response->getStatusCode() == 200) { // 200 OK
                //       $response_data = $response->getBody()->getContents();
                // }
                $userList->otp = $otp;
                $userList->otp_expiration_time = time();
                $userList->save();
                // if ($userList->save()) {
                //     return response()->json([
                //         "status" => 1,
                //         "responseCode" => "APP001",
                //         "message" => "OTP Sent",
                //         "otp" => $otp,
                //         "data" => json_decode("{}"),
                //     ]);
                // }
                $uname = 'wheelsniffer';
                $passwordd = '654321';
                $sender = 'WHLSNF';
                //  $tempid = '1707165097449419397';
                $route = 'TA';
                $msgtype = '1';

                // if($this->SendSms($phone,$message,$uname,$passwordd,$sender,$route,$msgtype)){


                return response()->json(["status" => 1, "responseCode" => "APP001", "message" => "OTP Sent", "otp" => $otp, "data" => json_decode("{}") , ]);
                // }

            }
            else
            {
                return response()->json(["status" => 0, "responseCode" => "NP997", "message" => "User not found. please register first", "data" => json_decode("{}") , ]);
            }
            // }

        }
        catch(Exception $e)
        {
            return response()->json(["status" => 0, "responseCode" => "NP997", "message" => "User update Error", "data" => json_decode("{}") , ]);
        }
    }

    public function authenticate(Request $request)
    {
        $status = 0;
        $message = "";

        $validator = Validator::make($request->all() , [
        // "mobile" => "required|string|max:10",
        "otp" => "required|string", ]);
        //$validator->errors()
        if ($validator->fails())
        {
            return response()
                ->json(["status" => $status, "responseCode" => "NP997", "message" => "invalid input details", "data" => json_decode("{}") , ]);
        }
        //echo $pwd = Hash::make($request->password).'      ='.$request->email; die;
        $validationChk = User::where('otp', $request->otp)
            ->get();

        if ($validationChk->count() == 0)
        {
            return response()
                ->json(["status" => $status, "responseCode" => "NP997", "message" => "invalid credentials", "data" => json_decode("{}") , ]);
        }
        // } elseif ($validationChk[0]->status != "1") {
        //     return response()->json([
        //         "status" => $status,
        //         "responseCode" => "NP997",
        //         "message" => "User not verified",
        //         "data" => json_decode("{}"),
        //     ]);
        // }
        $user = User::where("otp", "=", $request->otp)
            ->first();
        $address = Address::where('user_id', $user->id)
            ->first();

        if ($user)
        {
            try
            {
                $myTTL = 43200; //minutes
                JWTAuth::factory()->setTTL($myTTL);

                // verify the credentials and create a token for the user
                if (!($token = JWTAuth::fromUser($user)))
                {
                    return response()->json(["error" => "invalid_credentials"], 401);
                }
            }
            catch(JWTException $e)
            {
                // something went wrong
                return response()->json(["error" => "could_not_create_token"], 500);
            }
            // if no errors are encountered we can return a JWT
            $user = JWTAuth::setToken($token)->toUser();
            unset($user->otp);
            unset($user->verified_otp);
            $user->token = $token;
            $user->remember_token = $token;

            $user->firebase_token = (isset($request->firebase_token)) ? $request->firebase_token : '';

            $user->save();
            unset($user->remember_token);
            $status = 1;

            return response()->json(["status" => $status, "responseCode" => "APP001", "message" => $message, "data" => array_merge($user->toArray() , $address->toArray()) , ]);
        }
        else
        {
            return response()
                ->json(["status" => 0, "message" => "invalid credentials are wrong", "data" => "No User Found", ]);
        }
    }
}

