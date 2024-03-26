<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Attempt;

class AttemptGuessRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'number' => 'required|string|max:4|min:4',
           
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorGuess = Attempt::create([
            
            'cows'             => 0,
            'bulls'            => 0,             
            'error'            => 1
          ]);
    }
}
