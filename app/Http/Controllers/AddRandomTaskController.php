<?php

namespace App\Http\Controllers;

use App\Jobs\CreateRandomTasksForEveryUserJob;
use Illuminate\Http\Request;

class AddRandomTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        CreateRandomTasksForEveryUserJob::dispatch();
    }
}
