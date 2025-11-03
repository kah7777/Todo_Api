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
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = TaskResponseHandler::index();
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretaskRequest $request)
    {
        $response = TaskResponseHandler::store($request);
        return $response;

    }

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        $response = TaskResponseHandler::index();
        return $response;


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetaskRequest $request, task $task)
    {
        $response = TaskResponseHandler::index();
        return $response;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function done(task $task)
    {
        $response = TaskResponseHandler::done($task);
        return $response;
    }
}
