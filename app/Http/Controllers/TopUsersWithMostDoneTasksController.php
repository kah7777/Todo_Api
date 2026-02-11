<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TopUsersWithMostDoneTasksController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return Cache::remember('topUsersWithMostDoneTasksCache', 600, function () {
            return $users =  User::withCount(['tasks' => fn($query) => $query->where('done', 1)])
                ->orderByDesc('tasks_count')
                ->get()
                ->map(function ($users) {
                    return [
                        'id' => $users->id,
                        'username' => $users->username,
                        'tasks_count' => $users->tasks_count,
                    ];
                });
        });
    }
}
