<?php

namespace App\Http\Controllers\V1\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddressType;
use app\Models\Address;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function address_type_list(Request $request)
    {
        $address_type = AddressType::select('id', 'name')->get();
        if (count($address_type) > 0) {
            return response()->json(['status' => 1, 'message' => 'Data Found Successfully', 'data' => $address_type]);
        } else {
            return response()->json(['status' => 0, 'message' => 'No Data Found', 'data' => '']);
        }
    }


    public function address_list(Request $request)
    {
        $user = JWTAuth::user();
        if (!isset($user->id)) {
            return response()->json(["status" => 0, "message" => "User does not exist", "data" => json_decode("{}")]);
        }
        $address_type = DB::table('addresses')->join('users', 'users.id', 'addresses.user_id')
            ->join('address_type', 'address_type.id', 'addresses.address_type_id')
            ->where('addresses.user_id', $user->id)
            ->where('addresses.is_deleted', 0)
            ->select('addresses.*', 'users.name as username',  'address_type.name as address_type')
            ->get();
        if (count($address_type) > 0) {
            $list = array();
            foreach ($address_type as $i) {
                $c['address'] = $i->address;
                $c['zipcode']=$i->zip_code;
                $c['username'] = $i->username;
                $c['address_type'] = $i->address_type;


                array_push($list, $c);
            }

            return response()->json(['status' => 1, 'message' => 'Address Found Successfully', 'data' => $list]);
        } else {
            return response()->json(['status' => 0, 'message' => 'No Address Found', 'data' => json_decode("{}")]);
        }
    }

    public function delete_address(Request $request)
    {
        $user = JWTAuth::user();

        if (!isset($user->id)) {
            return response()->json(['status' => 0, 'message' => 'User does not exist', 'data' => json_decode("{}")]);
        }

        $validator = Validator::make($request->all(), [
            'address_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {

            return response()->json(["status" => 0, "message" => $validator->errors()->first(), "data" => json_decode("{}")]);
        }

        $address_check = DB::table('addresses')->where('id', $request->address_id)->where('is_deleted', 0)->first();
        if (empty($address_check)) {
            return response()->json(['status' => 0, 'message' => 'No Address Found', 'data' => '']);
        }
        DB::table('addresses')->where('id', $request->address_id)
            ->update([
                'is_deleted' => 1
            ]);

        return response()->json(['status' => 1, 'message' => 'Address Deleted Successfully', 'data' => json_decode("{}")]);
    }

    public function add_address(Request $request)
    {
        $user = JWTAuth::user();

        if (!isset($user->id)) {
            return response()->json(['status' => 0, 'message' => 'User does not exist', 'data' => json_decode("{}")]);
        }

        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'address_type_id' => 'required|numeric',
            'zip_code'=>'required|numeric',
        ]);

        if ($validator->fails()) {
            $error = json_decode(json_encode($validator->errors()));
            $errArr = [];
            foreach ($error as $k => $v) {
                $errArr[$k] = $v[0];
            }
            return response()->json(["status" => 0, "message" => "err", "data" => $errArr]);
        }
        $type_check = AddressType::where('id', $request->address_type_id)->first();
        if (empty($type_check)) {
            return response()->json(['status' => 0, 'message' => 'Address type id is Wrong', 'data' => '']);
        } else {
            if ($type_check->name == "Home") {

                $home_check = DB::table('addresses')->where('user_id', $user->id)->where('address_type_id', $request->address_type_id)->where('is_deleted', 0)->first();
                if (!empty($home_check)) {
                    return response()->json(['status' => 0, 'message' => 'Home Address already Stored', 'data' => '']);
                } else {
                    DB::table('addresses')->insert([
                        'user_id' => $user->id,
                        'address' => $request->address,
                        // 'address_arbic' => $request->address_arbic,
                        // 'city' => $request->city,
                        // 'city_arbic' => $request->city_arbic,
                        // 'state' => $request->state,
                        // 'state_arbic' => $request->state_arbic,
                        // 'country' => $request->country,
                        // 'country_arbic' => $request->country_arbic,
                        'zip_code' => $request->zip_code,
                        'address_type_id' => $type_check->id,
                        // 'latitude' => $request->latitude,
                        // 'longitude' => $request->longitude,
                        // 'map_address' => $request->map_address,
                    ]);
                }
            } elseif ($type_check->name == "Work") {
                $home_check = DB::table('addresses')->where('user_id', $user->id)->where('address_type_id', $request->address_type_id)->where('is_deleted', 0)->first();
                if (!empty($home_check)) {
                    return response()->json(['status' => 0, 'message' => 'Work Address already Stored', 'data' => '']);
                } else {
                    DB::table('addresses')->insert([
                        'user_id' => $user->id,
                        'address' => $request->address,
                        // 'address_arbic' => $request->address_arbic,
                        // 'city' => $request->city,
                        // 'city_arbic' => $request->city_arbic,
                        // 'state' => $request->state,
                        // 'state_arbic' => $request->state_arbic,
                        // 'country' => $request->country,
                        // 'country_arbic' => $request->country_arbic,
                        'zip_code' => $request->zip_code,
                        'address_type_id' => $type_check->id,
                        // 'latitude' => $request->latitude,
                        // 'longitude' => $request->longitude,
                        // 'map_address' => $request->map_address,
                    ]);
                }
            } else {
                $home_check = DB::table('addresses')->where('user_id', $user->id)->where('address_type_id', $request->address_type_id)->where('is_deleted', 0)->count();
                if ($home_check >= 10) {
                    return response()->json(['status' => 0, 'message' => 'Other Address Maximum limit reached', 'data' => '']);
                } else {
                    DB::table('addresses')->insert([
                        'user_id' => $user->id,
                        'address' => $request->address,
                        // 'address_arbic' => $request->address_arbic,
                        // 'city' => $request->city,
                        // 'city_arbic' => $request->city_arbic,
                        // 'state' => $request->state,
                        // 'state_arbic' => $request->state_arbic,
                        // 'country' => $request->country,
                        // 'country_arbic' => $request->country_arbic,
                        'zip_code' => $request->zip_code,
                        'address_type_id' => $type_check->id,
                        // 'latitude' => $request->latitude,
                        // 'longitude' => $request->longitude,
                        // 'map_address' => $request->map_address,
                    ]);
                }
            }
            $data = DB::table('addresses')->where('user_id', $user->id)
                ->join('users', 'users.id', 'addresses.user_id')
                ->join('address_type', 'address_type.id', 'addresses.address_type_id')
                ->where('addresses.is_deleted', 0)
                ->select('addresses.*', 'users.name as username',  'address_type.name as address_type')
                ->get();
            return response()->json(['status' => 1, 'message' => 'Address Added Successfully', 'data' => $data]);
        }
    }



}
