<?php

namespace App\Traits;

use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

trait TaskResponseHandler
{
    public static function index(IndexTaskRequest $request)
    {
        if(!Task::all()){
        $view = $request->view; //view is the way we show tasks , 0 for undone , 1 for done , 2 for both of them
        if($view == 0){
            $tasks = Task::where('done',0)->get();
            return $tasks;
        }elseif($view == 1){
            $tasks = Task::where('done',1)->get();
            return $tasks;
        }
        else{
            $tasks = Task::all();
            return $tasks;
        }}else{
            return response()->json([
                'message' => 'no task for today'
            ]);
        }
    }
    public static function store(StoreTaskRequest $request)
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

    public static function update(UpdateTaskRequest $request, Task $task)
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


