<?php

namespace App\Traits;

use App\Http\Controllers\TaskController;
use App\Http\Requests\StoretaskRequest;
use App\Http\Requests\UpdatetaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Mockery\Expectation;
use SebastianBergmann\Type\StaticType;

trait TaskResponseHandler
{
    public static function index()
    {
       try{
            $tasks = Task::all();
            return response()->json([
                'data' => $tasks,
                'message' => 'Response sent successfully'
            ],200);
        } catch(\Error $err) {
            return response()->json([
                'message' => $err->getMessage(),
            ], $err->getCode());
        }
    }
    public static function store(StoretaskRequest $request)
    {
        try{
            $data = $request->validated();
            $task = Task::create($data);
            return response()->json([
                'data' => $task,
                'message' => 'Response sent successfully'
            ],200);
        }catch(\Error $e)
        {
            return response()->json([
                'message' => $e
            ],$e->getCode());
        }
    }

    public static function update(UpdatetaskRequest $request, Task $task)
    {
        try{
            $data = $request->validated();
            $task->update($data);
            return response()->json([
                'data' => $task,
                'message' => 'Task updated successfully',
            ]);} catch(\Error $err)
            {
                return response()->json([
                    'message' => $err->getMessage(),
                ],$err->getCode(),);
            }
    }

        public static function show(Task $task)
    {
        try{
            $task = Task::findOrFail($task->id);
            return response()->json([
                'data'=>$task,
                'message'=>'Response sent successfully',
            ]);
        } catch(\Error $err){
            return response()->json([
                'message' => $err->getMessage(),
            ],$err->getCode());
        }
    }
}


