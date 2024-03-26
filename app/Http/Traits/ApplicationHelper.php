<?php

namespace App\Http\Traits;



trait ApplicationHelper {

    public function checkGuess($guess, $generatedNumber)
      {
          $cows = 0;
          $bulls = 0;
          $generatedNumber = implode('', $generatedNumber);
          for ($i = 0; $i < 4; $i++) {
              if ($guess[$i] == $generatedNumber[$i]) {
                  $bulls++;
              } elseif (strpos($generatedNumber, $guess[$i]) !== false) {
                  $cows++;
              }
          }

          $result = ['guess' => $guess , 'cows' => $cows, 'bulls' => $bulls];

          return $result;           
      }

    public function generateRandomNumber(){            
            
      //   Initialize an array with digits from 1 to 9
      $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];

      // Shuffle the array to randomize
      shuffle($numbers);    

      // Ensure 1 and 8 are next to each other
      $index1 = array_search(1, $numbers);
      $index8 = array_search(8, $numbers);
      if (abs($index1 - $index8) != 1) {
          // Swap 1 and 8 to ensure they're next to each other
          $temp = $numbers[$index1];       
          $numbers[$index1] = $numbers[$index8];
          $numbers[$index8] = $temp;
      }
      
      // Ensure 4 and 5 aren't on even indices
      $index4 = array_search(4, $numbers);
      $index5 = array_search(5, $numbers);
      $index1 = array_search(1, $numbers);
      $index8 = array_search(8, $numbers);    

      if ($index4 % 2 == 0 && $index5 != $index4 +1) {
        // Swap 4 and 5 with the next elements to ensure they're on odd indices
        $temp = $numbers[$index4];
        if($index4 + 1 != 9){
          $numbers[$index4] = $numbers[$index4 + 1];
        } else {
          $numbers[$index4] = $numbers[$index4 - 1];

        }        
        $numbers[$index4 + 1] = $temp;
      }

      if ($index5 % 2 == 0 && $index4 != $index5 +1) {
          // Swap 4 and 5 with the next elements to ensure they're on odd indices       
          $temp1 = $numbers[$index5];
          if($index5 + 1 != 9){
            $numbers[$index5] = $numbers[$index5 + 1];
          } else {
            $numbers[$index5] = $numbers[$index5 - 1];
          }
          $numbers[$index5 + 1] = $temp1;
      }    
      
      // Generate a 4-digit number
      
      $randomNumber = array_slice($numbers, 0, 4);
      $randomNumber2 = array_slice($numbers, 4, 9);    
    
      if(in_array(1,$randomNumber ) && in_array(8,$randomNumber )){

        $index1 = array_search(1, $randomNumber);
        $index8 = array_search(8, $randomNumber);

          if (abs($index1 - $index8) != 1) {
            // Swap 1 and 8 to ensure they're next to each other
            if($index1 == 0 || $index1 == 1 ){

              $temp = $randomNumber[$index1];
              
              $randomNumber[$index1] = $randomNumber[$index8];
              $randomNumber[$index8] = $randomNumber[$index1 + 1];
              $randomNumber[$index1 + 1] = $temp;

            }
            elseif($index8 == 0 || $index8 == 1 ){
          
              $temp = $randomNumber[$index8];
              $randomNumber[$index8] = $randomNumber[$index1];
              $randomNumber[$index1] = $randomNumber[$index8 + 1];
              $randomNumber[$index8 + 1] = $temp;

            }
          }
        }

        if(in_array(4, $randomNumber) && array_search(4, $randomNumber) % 2 == 0){

          if($randomNumber2[0] != 5){
              $randomNumber[array_search(4, $randomNumber)] = $randomNumber2[0] ;
          } else {
              $randomNumber[array_search(4, $randomNumber)] = $randomNumber2[1];
          }          
        }

        if(in_array(5, $randomNumber) && array_search(5, $randomNumber) % 2 == 0){
          if($randomNumber2[0] != 4){
            $randomNumber[array_search(5, $randomNumber)] = $randomNumber2[0];
          } else {              
            $randomNumber[array_search(5, $randomNumber)] = $randomNumber2[1];
          }        
        }

          return $randomNumber;
    }

}
