<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Task;
use App\States\User\Work;
use App\States\User\Vacation;
use App\States\Task\Assigned;
use App\States\Task\Progress;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'state' => User::getStatesFor('state')->random(),
            'password' => bcrypt(Str::random(10)),
            'remember_token' => Str::random(10),
        ];
    }

    /**  
     * Configure the model's default state.  
     *  
     * @return static  
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $roles = Role::get();

            $user->assignRole([$roles->random()]);

            if ($user->state instanceof Work) {
                // Получаем случайные задачи  
                $tasksCount = rand(1, 5);
                $tasks = Task::inRandomOrder()->whereState('state', [Assigned::class, Progress::class])->take($tasksCount)->pluck('id');

                // Присоединяем случайные задачи к пользователю  
                $user->tasks()->attach($tasks);
            }
        });
    }

    /**  
     * Define the programmer role.  
     *  
     * @return static  
     */
    public function programmer(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('programmer');
        });
    }

    /**  
     * Define the manager role.  
     *  
     * @return static  
     */
    public function manager(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('manager');
        });
    }

    /**  
     * Give the user a work state.  
     *  
     * @return static  
     */
    public function work(): static
    {
        return $this->state([
            'state' => Work::class,
        ]);
    }

    /**  
     * Give the user a vacation state.  
     *  
     * @return static  
     */
    public function vacation(): static
    {
        return $this->state([
            'state' => Vacation::class,
        ]);
    }
}
