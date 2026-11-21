<?php

namespace App\Providers;

use App\Http\Controllers\TaskController;
use App\Policies\TaskPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        TaskController::class => TaskPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
