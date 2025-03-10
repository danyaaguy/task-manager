<?php

namespace Database\Factories;

use App\Models\Task;
use App\States\Task\Assigned;
use App\States\Task\Progress;
use App\States\Task\Completed;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Преимущества:
     * Теперь факторка более разнообразная, что позволяет создавать задачи с различными состояниями.
     */

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'state' => Task::getStatesFor('state')->random(),
        ];
    }

    /**  
     * Set the task to be in assigned state.  
     *  
     * @return static  
     */
    public function assigned(): static
    {
        return $this->state([
            'state' => Assigned::class,
        ]);
    }

    /**  
     * Set the task to be in progress state.  
     *  
     * @return static  
     */
    public function progress(): static
    {
        return $this->state([
            'state' => Progress::class,
        ]);
    }

    /**  
     * Set the task to be in progress state.  
     *  
     * @return static  
     */
    public function completed(): static
    {
        return $this->state([
            'state' => Completed::class,
        ]);
    }
}
