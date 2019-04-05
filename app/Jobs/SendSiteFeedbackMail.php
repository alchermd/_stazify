<?php

namespace App\Jobs;

use App\Mail\SiteFeedbackSent;
use App\Models\SiteFeedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSiteFeedbackMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var SiteFeedback
     */
    public $feedback;

    /**
     * Create a new job instance.
     *
     * @param SiteFeedback $feedback
     */
    public function __construct(SiteFeedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(config('mail.admin'))
            ->send(new SiteFeedbackSent($this->feedback));
    }
}
