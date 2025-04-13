<?php

namespace App\Notifications;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Channels to send this notification through
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // You can remove 'mail' if you only want DB
    }

    /**
     * The mail representation
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Status Updated')
            ->line("The task '{$this->task->title}' has been updated.")
            ->line("New status: {$this->task->status}");
    }

    /**
     * The database representation
     */
    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'status' => $this->task->status,
            'updated_at' => $this->task->updated_at,
        ];
    }
}
