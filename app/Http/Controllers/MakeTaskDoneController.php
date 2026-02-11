<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeTaskDoneRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class MakeTaskDoneController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MakeTaskDoneRequest $request, Task $task)
    {
        $user = Auth::user();
        if ($task->user->id == $user->id) {
            try {
                $request->validated();
                $task->done = true;
                $task->save();

                return response()->json([
                    'data' => 'Task is done',
                    'message' => 'Response sent successfully',
                ]);
            } catch (\Error $err) {
                return response()->json([
                    'message' => $err->getMessage(),
                ], $err->getCode());
            }
        } else {
            return response()->json([
                'message' => 'You are not allowed to edit this task',
            ]);
        }
    }
}
