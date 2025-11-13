<?php

namespace App\Traits;

use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

trait TaskResponseHandler
{
    //views is integer for the user to filter tasks, 0 for undone , 1 for done , 2 for both
    public static function index(IndexTaskRequest $request)
    {
        $request->validated();
        $user = Auth::user();
        $view = $request->view;
        if ($view == 0) {
            $tasks = Task::where('user_id', $user->id)
                ->where('done', 0)
                ->get();
            Gate::authorize('index', $tasks->first());
            if ($tasks->first()) {
                return response()->json([
                    'data' => $tasks,
                    'message' => 'Response sent successfully',
                ]);
            } else {
                return response()->json([
                    'message' => 'No undone tasks for today'
                ]);
            }
        } elseif ($view == 1) {
            $tasks = Task::where('user_id', $user->id)
                ->where('done', 1)
                ->get();
            Gate::authorize('index', $tasks->first());
            if ($tasks->first()) {
                return response()->json([
                    'data' => $tasks,
                    'message' => 'Response sent successfully',
                ]);
            } else {
                return response()->json([
                    'message' => 'No done tasks for today',
                ]);
            }
        } else {
            $tasks = Task::where('user_id', $user->id)->get();
            Gate::authorize('index', $tasks->first());
            if ($tasks->first()) {
                return response()->json([
                    'data' => $tasks,
                    'message' => 'Response sent successfully',
                ]);
            } else {
                return response()->json([
                    'message' => 'no tasks listed'
                ]);
            }
        }
    }

    public static function store(StoreTaskRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $task = Task::create($data);
            return response()->json([
                'data' => $task,
                'message' => 'Response sent successfully'
            ], 200);
        } catch (\Error $e) {
            return response()->json([
                'message' => $e
            ], $e->getCode());
        }
    }

    public static function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        try {
            $data = $request->validated();
            $task->update($data);
            return response()->json([
                'data' => $task,
                'message' => 'Task updated successfully',
            ]);
        } catch (\Error $err) {
            return response()->json([
                'message' => $err->getMessage(),

            ], $err->getCode(),);
        }
    }

    public static function show(Task $task)
    {
        Gate::authorize('show', $task);
        try {
            $task = Task::findOrFail($task->id);
            return response()->json([
                'data' => $task,
                'message' => 'Response sent successfully',
            ]);
        } catch (\Error $err) {
            return response()->json([
                'message' => $err->getMessage(),
            ], $err->getCode());
        }
    }
}
