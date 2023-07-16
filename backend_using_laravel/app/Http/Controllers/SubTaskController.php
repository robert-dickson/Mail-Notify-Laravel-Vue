<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function index()
    {
        $subtasks = SubTask::all();
        return response()->json(['data' => $subtasks]);
    }

    public function store(Request $request)
    {
        $subtask = SubTask::create($request->all());
        return response()->json(['data' => $subtask], 201);
    }

    public function show(SubTask $subtask)
    {
        return response()->json(['data' => $subtask]);
    }

    public function update(Request $request, SubTask $subtask)
    {
        $subtask->update($request->all());
        return response()->json(['data' => $subtask]);
    }

    public function destroy(SubTask $subtask)
    {
        $subtask->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
    
}
