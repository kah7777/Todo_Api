<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller {
    //views is integer for the user to filter tasks, 0 for undone , 1 for done , 2 for both
    public function index(IndexTaskRequest $request)
    {
        Gate::authorize('index',Task::Class);
        $view = (int) $request->validated('view');
        $user = $request->user();
        $tasks = $user->tasks()
        ->when($view === 0, fn ($query) => $query->where('done', false))
        ->when($view === 1, fn ($query) => $query->where('done', true))
        ->get();
        $message = match (true) {
        $tasks->isNotEmpty() => 'Response sent successfully',
        $view === 0 => 'No tasks for today',
        $view === 1 => 'Your done tasks list is empty',
        default => 'No tasks listed',
    };
        return response()->json([
            'data' => $tasks,
            'messeges' => $message,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('store',Task::Class);
        $data['user_id'] = $request->user();
        $data = $request->validated();
        $task = Task::create($data);
        return response()->json([
            'data' => $task,
            'message' => 'Response sent successfully']);
    }

    public function update(UpdateTaskRequest $request, Task $task)
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

    public function show(Task $task)
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

    public function destroy(Task $task){
        Gate::authorize('delete',$task);
        $task->delete();
        return response()->noContent();
    }

}