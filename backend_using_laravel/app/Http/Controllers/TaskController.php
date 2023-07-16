<?php

namespace App\Http\Controllers;

use App\Mail\TaskReminder;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json(['data' => $tasks]);
    }

    public function store(Request $request)
    {

        $task = Task::create($request->all());
        return response()->json(['data' => $task], 201);
    }

    public function show(Task $task)
    {
        return response()->json(['data' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        try {
            $task->update($request->all());
            return response()->json(['data' => $task, 'message' => 'Task Updated Successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid data'], 400);
        }
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function TaskReminder(Request $request)
    {
        // Get the tasks that are "in progress" and not completed within 24 hours
        $tasksInProgress = Task::where('status', 'in progress')
            ->where('created_at', '<=', now()->subDay())
            ->get();

        foreach ($tasksInProgress as $task) {
            // Send reminder email to the email address associated with the task
            Mail::to($task->assigned_user_email)->send(new TaskReminder($task));
        }

        return response()->json(['message' => 'Task reminders sent successfully']);
    }

}
