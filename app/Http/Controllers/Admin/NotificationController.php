<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class NotificationController extends Controller
{
    public function index(){
        $data['messages']=Message::all();
        return view('admin/notification/index', $data);
    }
}
