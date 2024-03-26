<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attempt;
use App\Game;
use DB;

class AttemptController extends Controller
{
    
    public function index(Request $request){       
       
        if ($request->ajax()) {
            
            $data = Attempt::latest()->first();          

            return response()->json(['data' => $data]);
        }
    }

    public function ranking(){

        $games = Game::select('id','user_name', 'start_game', 'end_game')
            ->addSelect(DB::raw('TIMEDIFF(end_game, start_game) as time_taken'))
            ->orderByRaw('TIMEDIFF(end_game, start_game)')
            ->where('completed','=',1)
            ->limit(10)
            ->get();

        return response()->json($games);

    }
}
