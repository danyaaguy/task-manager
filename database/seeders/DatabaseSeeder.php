<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Добавляем роли
        Role::create(['name' => 'programmer']);
        Role::create(['name' => 'manager']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678')
        ]);

        // Создаем 20 пользователей  
        User::factory(20)->create();

        // Создаем 200 задач
        Task::factory(200)->create();

        // Привязываем задачи к случайным пользователям  
        foreach (Task::all() as $task) {
            $user = User::where('status', 1)->inRandomOrder()->first();

            $task->users()->attach($user->id);
        }
    }
}
