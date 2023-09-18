<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
  
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        $popularGenres = [
            "Action",
            "Adventure",
            "Role-Playing",
            "Shooter",
            "Strategy",
            "Sports",
            "Simulation",
            "Puzzle",
            "Racing",
            "Fighting",
        ];

        return [
            'title' => ['required', 'max:255'],
            'genre' => ['required', 'max:255', Rule::in($popularGenres)],
            'description' => ['required'],
            'release_date' => ['required', 'date_format:Y-m-d'],
        ];
    }
    public function messages()
    {
        $popularGenres = [
            "Action",
            "Adventure",
            "Role-Playing",
            "Shooter",
            "Strategy",
            "Sports",
            "Simulation",
            "Puzzle",
            "Racing",
            "Fighting",
        ];

        return [
            'genre.in' => 'The selected genre is invalid. Select one of the following: ' . implode(", ", $popularGenres),
        ];
    }
}
