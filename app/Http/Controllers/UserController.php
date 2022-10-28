<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //


    public function create(Request $request)
    {
        //
        $dat = $request->all();
         $validator = Validator::make($request->all(), [
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                "statuscode" => 422,
                "message" => $validator->errors()
            ],422);
        } 
        
        $usr = new User;
        $usr->email=$usr->name=$dat["email"];
        $usr->password=Hash::make($dat["password"]);
        $usr->save();
       
        return response()->json([
            "statuscode" => 200,
            "message" => "User berhasil ditambahkan"
        ],200);
    }

    public function edit(Request $request,$id) {
        $dat = $request->all();
         $validator = Validator::make($request->all(), [
            'email'     => 'required|email|unique:users,id,'.$id,
            'password'  => 'required|string'            
        ]);

        if($validator->fails()){
            return response()->json([
                "statuscode" => 422,
                "message" => $validator->errors()
            ],422);
        }   
        
        $usr = User::find($id);
        $usr->email=$usr->name=$dat["email"];
        $usr->password=Hash::make($dat["password"]);
        $usr->save();
       
        return response()->json([
            "statuscode" => 200,
            "message" => "User berhasil diupdate"
        ],200);
    }

    public function delete(Request $request, $id) {
        $dat = $request->all();
        // $validator = Validator::make($request->all(), [
        //     'id' => 'required',
        // ]);

        // if($validator->fails()){
        //     return response()->json([
        //         "success" => false,
        //         "message" => $validator->errors()
        //     ],422);
        // } 
        
        $usr = User::find($id);
        $usr->delete();
       
        return response()->json([
            "statuscode" => 200,
            "message" => "User berhasil dihapus"
        ],200);
    }

    public function get_Users(Request $request) {
        $dat = $request->all();
        $usr = User::all();
        if(!$usr->isEmpty()) {
            return response()->json([
                "statuscode" => 200,
                "message" => "Data Ditemukan",
                "data" => $usr 
            ],200);
        }
        else {
            return response()->json([
                "statuscode" => 404,
                "message" => "User tidak ditemukan"
            ],404);
        }    
    }

    public function get_user_detail(Request $request,$id) {
        $dat = $request->all();
        $usr = User::find($id);
        if(!empty($usr)) {
            return response()->json([
                "statuscode" => 200,
                "message" => "User ditemukan",
                "data" =>$usr
            ],200);
        }
        else {
            return response()->json([
                "statuscode" => 404,
                "message" => "User tidak ditemukan"
            ],404);
        }    
    }

    public function logout (Request $request) {
        // print_r($request->user());
        // exit();
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    
    
    public function login(Request $request) {
        $dat    = $request->all();
        //DB::enableQueryLog();
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|string'            
        ]);

        if($validator->fails()){
            return response()->json([
                "statuscode" => 422,
                "message" => $validator->errors()->first()
            ],422);
        }
        
        $usr    = User::where('email',$dat["email"])
                   ->first();
        if($usr) {
            if (Hash::check($dat["password"] , $usr->password)) {
                $token = $usr->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response()->json([
                    "statuscode" => 200,
                    "message" => "Login Valid",
                    "data" =>$usr,
                    "token" => $token
                ],200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
    
            
        }
        else {
            return response()->json([
                "statuscode" => 401,
                "message" => "Alamat Email Tidak ditemukan"
            ],401);
        }    
    }

}
