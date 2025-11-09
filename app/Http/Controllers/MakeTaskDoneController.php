<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MakeTaskDoneController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Task $task)
    {
        try{
            $task->done == true;
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
}
