<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Image;

class ResizeProfilePictureJob implements ShouldQueue
{
    use Queueable;

    protected $image;

    /**
     * Create a new job instance.
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     */
    public function handle($image): void
    {
        $name = $image->name;
        Image::load($name)
            ->quality(70)
            ->save();
    }
}
