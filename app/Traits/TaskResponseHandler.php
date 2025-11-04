<?php

namespace App\Traits;

use App\Http\Controllers\TaskController;
use App\Http\Requests\StoretaskRequest;
use App\Http\Requests\UpdatetaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        } catch(\Exception $err) {
            return response()->json([
                'message' => $err->getMessage(),
            ], $err->getCode());
        }
    }
    public static function store(StoretaskRequest $request)
    {
       try{
            $data = $request->validated();
            $task = Task::create($data) ;
            return response()->json([
                'data' => $task,
                'message' => 'Response sent successfully'
            ],200);
        } catch(\Exception $err){
            return response()->json([
                'message' => $err->getMessage(),
            ], $err->getCode());
        }
    }

        public function show(task $task)
    {
        try{
            return Task::find($task->id);
        } catch (\Exception $err){
            return response()->json([
                'message' => $err->getMessage(),
            ],$err->getCode());
        }
    }
        public static function update(UpdatetaskRequest $request, task $task)
    {
       try{
            $data = $request->validated();
            $task = Task::update($data) ;
            return response()->json([
                'data' => $task,
                'message' => 'Response sent successfully'
            ],200);
        } catch(\Exception $err){
            return response()->json([
                'message' => $err->getMessage(),
            ], $err->getCode());
        }
    }

    public static function done($task)
    {
        try{
            $task->done=='true';
            return response()->json([
                'message' => 'Task is done',
            ]);
        } catch(\Exception $err){
            return response()->json([
                'message'=>$err,
            ]);
        }
    }
}


