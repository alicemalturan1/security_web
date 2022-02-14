<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function login(Request $req){
        $req->validate([
            'username'=>'required',
            'password'=>'required'
        ]);
        if(Auth::attempt(['username'=>$req->username,'password'=>$req->password],$req->remember_me)){
            return response([
                'success'=>true,
                'time'=>Carbon::now()
            ]);
        }
        return response([
            'success'=>false,
            'time'=>Carbon::now()
        ]);
    }
    public function register(Request $req){
        $req->validate([
            'username'=>'required',
            'password'=>'required',
            'name_surname'=>'required',
            'degree'=>'required'
        ]);
        $is_client=0;$is_admin=0;$is_worker=0;
        if($req->degree==0)$is_admin=1;
        if($req->degree==1)$is_worker=1;
        if($req->degree==2)$is_client=1;

        User::insert([
            'name_surname'=>$req->name_surname,
            'username'=>$req->username,
            'password'=>bcrypt($req->password),
            'about'=>$req->about,
            'phone_number'=>$req->phone_number,
            'is_admin'=>$is_admin,
            'is_client'=>$is_client,
            'is_worker'=>$is_worker,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'avatar'=>$req->avatar
        ]);
        return response(['success'=>true]);
    }
}
