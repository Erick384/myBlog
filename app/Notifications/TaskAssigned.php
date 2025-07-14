<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Task Assigned: ' . $this->task->title)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('You have been assigned a new task.')
                    ->line('Task: ' . $this->task->title)
                    ->line('Description: ' . $this->task->description)
                    ->line('Deadline: ' . $this->task->deadline->format('Y-m-d H:i:s'))
                    ->action('View Task', url('/tasks/' . $this->task->id))
                    ->line('Thank you for using our task management system!');
    }
}
