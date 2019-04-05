<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationSent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Application
     */
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
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        $channels = collect(['database']);

        if ($notifiable->wants_email_notifications) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('An application has been sent to one of your jobposts')
            ->action('View Applications', url('/home/applications'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'image' => $this->application->user->avatar_url,
            'image_link' => '/home/students/'.$this->application->user->id,
            'message' => "<strong>{$this->application->user->full_name }</strong> 
                has sent an application for
                <strong>{$this->application->jobpost->title}</strong>",
            'message_link' => '/home/applications/'.$this->application->id,
        ];
    }
}
