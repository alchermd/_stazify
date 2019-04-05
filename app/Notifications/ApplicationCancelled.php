<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    private $application;

    /**
     * Create a new notification instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line("{$this->application->user->name} has cancelled their application on \"{$this->application->jobpost->title}\"")
            ->action('Go to my dashboard', url('/home'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'image' => $this->application->user->avatar_url,
            'image_link' => '/home/students/'.$this->application->user->id,
            'message' => "<strong>{$this->application->user->name}</strong> has cancelled their application for <strong>{$this->application->jobpost->title}</strong>",
            'message_link' => '/home/applications/'.$this->application->id,
        ];
    }
}
