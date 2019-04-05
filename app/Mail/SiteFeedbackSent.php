<?php

namespace App\Mail;

use App\Models\SiteFeedback;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiteFeedbackSent extends Mailable
{
    use Queueable, SerializesModels;

    public $feedback;

    /**
     * Create a new message instance.
     *
     * @param SiteFeedback $feedback
     */
    public function __construct(SiteFeedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.feedbacks.sent');
    }
}
