<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Cities;

class CityController extends Controller
{
    //
    public function get_cities() {
        $citieslist = Cities::all();
        if($citieslist) {
            return response()->json([
                "statuscode" => 200,
                "message" => "Data ditemukan",
                "data" => $citieslist
            ],200);
        }
        else {
            return response()->json([
                "statuscode" => 404,
                "message" => "Data tidak ditemukan"
            ],404);
        }    
    }

}
