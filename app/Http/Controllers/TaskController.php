<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Http\Requests\StoretaskRequest;
use App\Http\Requests\UpdatetaskRequest;
use App\Traits\TaskResponseHandler;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of all tasks.
     */
    public function index()
    {
        $response = TaskResponseHandler::index();
        return $response;
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoretaskRequest $request)
    {
        $response = TaskResponseHandler::store($request);
        return $response;
    }

  /**
     * Update the specified task in storage.
     */
    public function update(UpdatetaskRequest $request, Task $task)
    {
        $response = TaskResponseHandler::update($request,$task);
        return $response;
    }

    /**
     * Show the specified task in storage.
     */
    public function show(task $task)
    {
        $response = TaskResponseHandler::show($task);
        return $response;
    }

        public function indexDone()
    {
        $response = TaskResponseHandler::indexDone();
        return $response;
    }

            public function makeTaskDone()
    {
        $response = TaskResponseHandler::makeTaskDone();
        return $response;
    }
}
