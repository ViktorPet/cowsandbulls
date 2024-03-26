<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attempt;

class AttemptController extends Controller
{
    
    public function index(Request $request){

       
       
        if ($request->ajax()) {

            
            $data = Attempt::latest()->first(); 

          

            return response()->json(['data' => $data]);
        }

    }
}
