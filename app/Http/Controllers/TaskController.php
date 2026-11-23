<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(IndexTaskRequest $request)
    {
        Gate::authorize('index', Task::class);
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
            'message' => $message,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('store', Task::class);
        $task = $request->user()->tasks()->create($request->validated());

        return response()->json([
            'data' => $task,
            'message' => 'Response sent successfully'], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        $data = $request->validated();
        $task->update($data);

        return response()->json([
            'data' => $task,
            'message' => 'Task updated successfully',
        ]);
    }

    public function show(Task $task)
    {
        Gate::authorize('show', $task);

        return response()->json([
            'data' => $task,
            'message' => 'Response sent successfully',
        ]);
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();

        return response()->noContent();
    }
}
