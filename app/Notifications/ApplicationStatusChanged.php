<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Application */
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The status of one of your sent applications has been changed.')
            ->action(
                'View Application',
                route('applications.show', [
                    'application' => $this->application->id
                ])
            )
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
            'image' => $this->application->getCompany()->avatar_url,
            'image_link' => '/home/companies/' . $this->application->getCompany()->id,
            'message' => sprintf(
                    'Your application for <strong>%s</strong> has been changed to %s.',
                    $this->application->jobpost->title,
                    $this->application->accepted ? 'accepted' : 'rejected'
                ),
            'message_link' => '/home/applications/' . $this->application->id,
        ];
    }
}
