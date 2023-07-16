<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'parent_id', 'status'];

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
}
