<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class Usercontroller extends Controller
{
    public function index($name){
        return view('users',['name'=>$name,'user'=>['peter','akshay','sam']]);
    }
    public function getData(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'

        ]);

        return $request->input();
        
        return "form data will be here";
    }
    public function fetchdata(){
        return User::all();
    }
    public function HttpClient(){
       $collection= Http::get('https://reqres.in/api/users?page=1');
       return view('Httpclient',['collection'=>$collection['data']]);
    }
}
