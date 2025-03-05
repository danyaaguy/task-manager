<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->numberBetween(0, 2);  

        return [  
            'title' => fake()->sentence(),  
            'description' => fake()->paragraph(),  
            'status' => $status,  
            'user_id' => User::inRandomOrder()->first()->id,  
        ]; 
    }
}
