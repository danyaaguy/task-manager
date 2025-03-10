<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Task;  
use App\Observers\TaskObserver;  

class AppServiceProvider extends ServiceProvider
{
    /**
     * Преимущества:
     * Для предотвращения написания n+1 запросов используем жадную загрузку данных.
     * Для отправки данных с API используем единый формат ответов ApiResource
     */

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('tasks', function (Request $request) {
            return Limit::perMinute(2)->by($request->user()?->id ?: $request->ip());
        });

        Task::observe(TaskObserver::class);
    }
}
