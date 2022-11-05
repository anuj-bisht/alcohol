<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function viewProfile()
    {
        return view('profile.edit');

    }
    public function updateProfile(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'name' => ['required', 'min:3'],
            'email' => 'required|email'
        ]);
        auth()->user()->update($validate->validated());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }


    public function searchData(Request $request){
     $data['userdata']=User::where('role',2)->whereBetween('created_at',[$request->start_date, $request->end_date])->get();
     $data['usercount']=User::where('role',2)->whereBetween('created_at',[$request->start_date, $request->end_date])->count();

     $data['totalsale']=Order::where('order_status_id',1)->whereBetween('created_at',[$request->start_date, $request->end_date])->sum('total');

     return response()->json($data);
    }


}
