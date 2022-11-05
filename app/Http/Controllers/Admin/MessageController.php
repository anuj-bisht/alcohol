<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    public function index(){
        $data['messages']=Message::all();
        return view('admin/message/index', $data);
    }

    public function create(){
        return view('admin.message.create');
    }

    public function store(Request $request){
        $validate=Validator::make($request->all(), [
            'message'=>'required'
        ]);
        Message::create($validate->validated());
        Session::flash('message', "Notification Message Add Successfully");
        return \redirect()->route('message.show');
    }

    public function edit(Message $id){

        $data['message']=$id;
        return view('admin.message.edit', $data);
    }

    public function update(Request $request, $id){
        $validate=Validator::make($request->all(), [
            'message'=>'required'
        ]);
        Message::where('id',$id)->update(['message'=>$request->message]);
        Session::flash('message', "Notification Message Update Successfully");
        return \redirect()->route('message.show');

    }

    public function deleteMessage($id)
    {

        Message::where('id', $id)->delete();

        return response()->json(['message'=>'data deleted']);

    }

}
