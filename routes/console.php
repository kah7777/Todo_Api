<?php

use App\Models\Task;
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
            ->whereNull('notified_at')
            ->with('user')
            ->get();
        if ($tasks->isEmpty()) {
            return;
        }
        $tasks->groupBy('user_id')->each(function ($userTasks) {
            $userTasks->first()->user->notify(new TasksWithEndedDeadlinesNotification($userTasks));
        });

        Task::whereIn('id', $tasks->pluck('id'))->update(['notified_at' => now()]);
    }

)->everyMinute();
