<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\ApplicationHelper;
use App\Http\Requests\StartGameRequest;
use App\Http\Requests\AttemptGuessRequest;
use Illuminate\Support\Facades\Validator;
use App\Game;
use App\Attempt;

      class GameController extends Controller
      {

        use ApplicationHelper;
     
        public function index()
        {
            $currentGame = Game::where('completed','=', 0)->first();
            $attempts = Attempt::all();
            if($currentGame != null && $attempts != null){
              return view('index', compact('currentGame', 'attempts'));
            } else {

              return view('index');
            }
          
        }

        public function start(StartGameRequest $request){

          $validatedData = $request->validated();
          
           Game::create([
              'user_name'  => $request->user_name,
              'start_game' => now()
            ]);

            $game = Game::latest()->first();

          
            Session::put([
              'user_name'    => $request->user_name,
              'randomNumber' => $this->generateRandomNumber(),
              'game_id'      => $game->id         
          ]);

            return response()->json(['message' => 'Data saved successfully']);

        }

        public function guess(AttemptGuessRequest $request){
          
            $validatedData = $request->validated(); 
         //   dd($request->all());
          //   dd($validatedData);
           // $number_to_guess = session('randomNumber');

          //   $validator = Validator::make($request->all(), [
          //     'number' => 'required|string|max:4|min:4',
           
          //   ])->validate();

          //   //dd($validator);

          // if ($validator->fails()) 
          //   { 
          //   //  dd('hy');
          //     $errorGuess = Attempt::create([
          //       'game_id'          => 1,
          //       'cows'             => 0,
          //       'bulls'            => 0,             
          //       'error'            => 1
          //     ]);
          //   }

              $number = $request->number;

              $number_to_guess = session('randomNumber');
  
               print_r($number_to_guess);
  
              // echo implode('',$number_to_guess);
  
              $guess = $this->checkGuess($number, $number_to_guess);
              print_r($guess);
  
              if($guess['bulls'] == 4){
  
                $data = $request->session()->all();
  
                $lastGuess = Attempt::create([
                  'game_id'          => $data['game_id'],
                  'cows'             => $guess['cows'],
                  'bulls'            => $guess['bulls'],
                  'number_to_guess'  => implode('',$number_to_guess)
                ]);
  
                //dd($data);
  
                Game::where('id', $data['game_id'])
                ->update(['completed' => 1 , 'end_game' => now()]);
  
                $request->session()->forget(['user_name', 'game_id', 'randomNumber']);
   
               // $request->session()->flush();
              } else {
                $data = $request->session()->all();

                $currentGame = Game::where('completed','=', 0)->where('id', '=', $data['game_id'])->first();
           
                $currentGuess = Attempt::create([
                  'game_id'          => $currentGame->id,
                  'cows'             => $guess['cows'],
                  'bulls'            => $guess['bulls'],
                  'number_to_guess'  => implode('',$number_to_guess)
                ]);
  
                return response()->json(['message' => 'Data saved successfully']);
  
  
              }       
              




            
          
           

            

        }

       

        
      }
