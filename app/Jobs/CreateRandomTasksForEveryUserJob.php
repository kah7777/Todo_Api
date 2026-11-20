<?php

namespace App\Jobs;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateRandomTasksForEveryUserJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $seeder = new DatabaseSeeder;
        $seeder->run();
    }
}
