<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeTaskDoneRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class MakeTaskDoneController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MakeTaskDoneRequest $request, Task $task)
    {
        try {
            $request->validated();
            $task->done = true;
            $task->save();
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
