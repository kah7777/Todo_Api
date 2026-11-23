<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected function casts(): array
    {
        return [
            'dead_line' => 'datetime',
            'notified_at' => 'datetime',
            'done' => 'boolean',

        ];
    }

    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
