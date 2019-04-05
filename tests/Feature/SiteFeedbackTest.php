<?php

namespace Tests\Feature;

use App\Jobs\SendSiteFeedbackMail;
use App\Mail\SendSiteFeedback;
use App\Mail\SiteFeedbackSent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SiteFeedbackTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_feedback_page_exists()
    {
        $this->get('/feedback')->assertOk();
    }

    /** @test */
    public function the_message_is_saved_in_the_database_after_submission()
    {
        $this->post('/feedback', [
            'email' => 'me@example.com',
            'message' => 'Your site is awesome!',
            'reply_me' => 'on',
        ])->assertRedirect('/feedback?message_sent=1');

        $this->assertDatabaseHas('site_feedbacks', [
            'email' => 'me@example.com',
            'message' => 'Your site is awesome!',
            'reply_me' => true,
        ]);
    }

    /** @test */
    public function an_email_is_sent_to_the_admin_when_a_feedback_is_sent()
    {
        Mail::fake();

        $this->post('/feedback', [
            'email' => 'me@example.com',
            'message' => 'Your site is awesome!',
            'reply_me' => 'on',
        ])->assertRedirect('/feedback?message_sent=1');

        Mail::assertSent(SiteFeedbackSent::class);
    }

    /** @test */
    public function a_job_is_queued_when_a_feedback_is_sent()
    {
        Queue::fake();

        $this->post('/feedback', [
            'email' => 'me@example.com',
            'message' => 'Your site is awesome!',
            'reply_me' => 'on',
        ])->assertRedirect('/feedback?message_sent=1');

        Queue::assertPushed(SendSiteFeedbackMail::class);
    }

    /** @test */
    public function a_message_sent_successfully_page_exists()
    {
        $this->get('/feedback?message_sent=1')->assertOk();
    }
}
