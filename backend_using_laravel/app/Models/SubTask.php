<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'task_id', 'status'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
