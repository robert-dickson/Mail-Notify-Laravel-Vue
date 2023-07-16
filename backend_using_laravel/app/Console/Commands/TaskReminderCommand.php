<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TaskReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks in progress but not completed';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $tasks = Task::where('status', 'in progress')
            ->whereDate('created_at', '<=', Carbon::now()->subMinutes(1))
            ->get();

        foreach ($tasks as $task) {
            $user = $task->user; // Assuming you have a 'user' relationship defined in the Task model

            // Make sure the task has an associated user before proceeding
            if ($user && $user->email) {
                // Send reminder email to the task owner
                Mail::raw('Reminder: Task in progress but not completed', function ($message) use ($user, $task) {
                    $message->to($user->email)
                        ->subject('Task Reminder')
                        ->line("Task: $task->title");
                });
            }
        }

        $this->info('Task reminders sent successfully!');
    }
}
