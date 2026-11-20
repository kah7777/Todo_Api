<?php

use App\Models\Task;
use App\Models\User;
use App\Notifications\TasksWithEndedDeadlinesNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(
    function () {
        $tasks = Task::where('dead_line', '<=', now())
            ->where('done', 0)
            ->get();

        if ($tasks->isEmpty()) {
            return;
        }

        $user = User::find('user_id');
        $user->notify(new TasksWithEndedDeadlinesNotification($tasks));
    }

)->everyMinute();
