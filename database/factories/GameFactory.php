<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class GameFactory extends Factory
{


    public function definition()
    {
        // Define an array of predefined categories
        $categories = ['Action', 'Adventure', 'Role-Playing', 'Simulation', 'Strategy', 'Puzzle', 
        'Shooter', 'Sports', 'Racing', 'Fighting'];
   
    
        return [
            'user_id' => User::all()->random()->id,
            'title' => $this->faker->unique()->sentence(),
            'genre' => $this->faker->randomElement($categories),
            'description' => $this->faker->paragraph(),
            'release_date' => $this->faker->date()
        ];
    }
}
