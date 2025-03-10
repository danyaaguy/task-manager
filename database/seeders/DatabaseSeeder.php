<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //TODO: Все в одном сидере,
        //TODO: Нет вариативности создаваемых объектов
        //TODO: Используется all() от модели

        Role::create(['name' => 'programmer']);
        Role::create(['name' => 'manager']);

        // Создаем 200 задач
        Task::factory(200)->create();

        // Создаем 20 пользователей
        User::factory(20)->create();
    }
}
